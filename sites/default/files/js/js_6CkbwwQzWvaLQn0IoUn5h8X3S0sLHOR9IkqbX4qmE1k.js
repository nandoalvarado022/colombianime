(function ($) {

/**
 * Drag and drop table rows with field manipulation.
 *
 * Using the drupal_add_tabledrag() function, any table with weights or parent
 * relationships may be made into draggable tables. Columns containing a field
 * may optionally be hidden, providing a better user experience.
 *
 * Created tableDrag instances may be modified with custom behaviors by
 * overriding the .onDrag, .onDrop, .row.onSwap, and .row.onIndent methods.
 * See blocks.js for an example of adding additional functionality to tableDrag.
 */
Drupal.behaviors.tableDrag = {
  attach: function (context, settings) {
    for (var base in settings.tableDrag) {
      $('#' + base, context).once('tabledrag', function () {
        // Create the new tableDrag instance. Save in the Drupal variable
        // to allow other scripts access to the object.
        Drupal.tableDrag[base] = new Drupal.tableDrag(this, settings.tableDrag[base]);
      });
    }
  }
};

/**
 * Constructor for the tableDrag object. Provides table and field manipulation.
 *
 * @param table
 *   DOM object for the table to be made draggable.
 * @param tableSettings
 *   Settings for the table added via drupal_add_dragtable().
 */
Drupal.tableDrag = function (table, tableSettings) {
  var self = this;

  // Required object variables.
  this.table = table;
  this.tableSettings = tableSettings;
  this.dragObject = null; // Used to hold information about a current drag operation.
  this.rowObject = null; // Provides operations for row manipulation.
  this.oldRowElement = null; // Remember the previous element.
  this.oldY = 0; // Used to determine up or down direction from last mouse move.
  this.changed = false; // Whether anything in the entire table has changed.
  this.maxDepth = 0; // Maximum amount of allowed parenting.
  this.rtl = $(this.table).css('direction') == 'rtl' ? -1 : 1; // Direction of the table.

  // Configure the scroll settings.
  this.scrollSettings = { amount: 4, interval: 50, trigger: 70 };
  this.scrollInterval = null;
  this.scrollY = 0;
  this.windowHeight = 0;

  // Check this table's settings to see if there are parent relationships in
  // this table. For efficiency, large sections of code can be skipped if we
  // don't need to track horizontal movement and indentations.
  this.indentEnabled = false;
  for (var group in tableSettings) {
    for (var n in tableSettings[group]) {
      if (tableSettings[group][n].relationship == 'parent') {
        this.indentEnabled = true;
      }
      if (tableSettings[group][n].limit > 0) {
        this.maxDepth = tableSettings[group][n].limit;
      }
    }
  }
  if (this.indentEnabled) {
    this.indentCount = 1; // Total width of indents, set in makeDraggable.
    // Find the width of indentations to measure mouse movements against.
    // Because the table doesn't need to start with any indentations, we
    // manually append 2 indentations in the first draggable row, measure
    // the offset, then remove.
    var indent = Drupal.theme('tableDragIndentation');
    var testRow = $('<tr/>').addClass('draggable').appendTo(table);
    var testCell = $('<td/>').appendTo(testRow).prepend(indent).prepend(indent);
    this.indentAmount = $('.indentation', testCell).get(1).offsetLeft - $('.indentation', testCell).get(0).offsetLeft;
    testRow.remove();
  }

  // Make each applicable row draggable.
  // Match immediate children of the parent element to allow nesting.
  $('> tr.draggable, > tbody > tr.draggable', table).each(function () { self.makeDraggable(this); });

  // Add a link before the table for users to show or hide weight columns.
  $(table).before($('<a href="#" class="tabledrag-toggle-weight"></a>')
    .attr('title', Drupal.t('Re-order rows by numerical weight instead of dragging.'))
    .click(function () {
      if ($.cookie('Drupal.tableDrag.showWeight') == 1) {
        self.hideColumns();
      }
      else {
        self.showColumns();
      }
      return false;
    })
    .wrap('<div class="tabledrag-toggle-weight-wrapper"></div>')
    .parent()
  );

  // Initialize the specified columns (for example, weight or parent columns)
  // to show or hide according to user preference. This aids accessibility
  // so that, e.g., screen reader users can choose to enter weight values and
  // manipulate form elements directly, rather than using drag-and-drop..
  self.initColumns();

  // Add mouse bindings to the document. The self variable is passed along
  // as event handlers do not have direct access to the tableDrag object.
  $(document).bind('mousemove', function (event) { return self.dragRow(event, self); });
  $(document).bind('mouseup', function (event) { return self.dropRow(event, self); });
};

/**
 * Initialize columns containing form elements to be hidden by default,
 * according to the settings for this tableDrag instance.
 *
 * Identify and mark each cell with a CSS class so we can easily toggle
 * show/hide it. Finally, hide columns if user does not have a
 * 'Drupal.tableDrag.showWeight' cookie.
 */
Drupal.tableDrag.prototype.initColumns = function () {
  for (var group in this.tableSettings) {
    // Find the first field in this group.
    for (var d in this.tableSettings[group]) {
      var field = $('.' + this.tableSettings[group][d].target + ':first', this.table);
      if (field.length && this.tableSettings[group][d].hidden) {
        var hidden = this.tableSettings[group][d].hidden;
        var cell = field.closest('td');
        break;
      }
    }

    // Mark the column containing this field so it can be hidden.
    if (hidden && cell[0]) {
      // Add 1 to our indexes. The nth-child selector is 1 based, not 0 based.
      // Match immediate children of the parent element to allow nesting.
      var columnIndex = $('> td', cell.parent()).index(cell.get(0)) + 1;
      $('> thead > tr, > tbody > tr, > tr', this.table).each(function () {
        // Get the columnIndex and adjust for any colspans in this row.
        var index = columnIndex;
        var cells = $(this).children();
        cells.each(function (n) {
          if (n < index && this.colSpan && this.colSpan > 1) {
            index -= this.colSpan - 1;
          }
        });
        if (index > 0) {
          cell = cells.filter(':nth-child(' + index + ')');
          if (cell[0].colSpan && cell[0].colSpan > 1) {
            // If this cell has a colspan, mark it so we can reduce the colspan.
            cell.addClass('tabledrag-has-colspan');
          }
          else {
            // Mark this cell so we can hide it.
            cell.addClass('tabledrag-hide');
          }
        }
      });
    }
  }

  // Now hide cells and reduce colspans unless cookie indicates previous choice.
  // Set a cookie if it is not already present.
  if ($.cookie('Drupal.tableDrag.showWeight') === null) {
    $.cookie('Drupal.tableDrag.showWeight', 0, {
      path: Drupal.settings.basePath,
      // The cookie expires in one year.
      expires: 365
    });
    this.hideColumns();
  }
  // Check cookie value and show/hide weight columns accordingly.
  else {
    if ($.cookie('Drupal.tableDrag.showWeight') == 1) {
      this.showColumns();
    }
    else {
      this.hideColumns();
    }
  }
};

/**
 * Hide the columns containing weight/parent form elements.
 * Undo showColumns().
 */
Drupal.tableDrag.prototype.hideColumns = function () {
  // Hide weight/parent cells and headers.
  $('.tabledrag-hide', 'table.tabledrag-processed').css('display', 'none');
  // Show TableDrag handles.
  $('.tabledrag-handle', 'table.tabledrag-processed').css('display', '');
  // Reduce the colspan of any effected multi-span columns.
  $('.tabledrag-has-colspan', 'table.tabledrag-processed').each(function () {
    this.colSpan = this.colSpan - 1;
  });
  // Change link text.
  $('.tabledrag-toggle-weight').text(Drupal.t('Show row weights'));
  // Change cookie.
  $.cookie('Drupal.tableDrag.showWeight', 0, {
    path: Drupal.settings.basePath,
    // The cookie expires in one year.
    expires: 365
  });
  // Trigger an event to allow other scripts to react to this display change.
  $('table.tabledrag-processed').trigger('columnschange', 'hide');
};

/**
 * Show the columns containing weight/parent form elements
 * Undo hideColumns().
 */
Drupal.tableDrag.prototype.showColumns = function () {
  // Show weight/parent cells and headers.
  $('.tabledrag-hide', 'table.tabledrag-processed').css('display', '');
  // Hide TableDrag handles.
  $('.tabledrag-handle', 'table.tabledrag-processed').css('display', 'none');
  // Increase the colspan for any columns where it was previously reduced.
  $('.tabledrag-has-colspan', 'table.tabledrag-processed').each(function () {
    this.colSpan = this.colSpan + 1;
  });
  // Change link text.
  $('.tabledrag-toggle-weight').text(Drupal.t('Hide row weights'));
  // Change cookie.
  $.cookie('Drupal.tableDrag.showWeight', 1, {
    path: Drupal.settings.basePath,
    // The cookie expires in one year.
    expires: 365
  });
  // Trigger an event to allow other scripts to react to this display change.
  $('table.tabledrag-processed').trigger('columnschange', 'show');
};

/**
 * Find the target used within a particular row and group.
 */
Drupal.tableDrag.prototype.rowSettings = function (group, row) {
  var field = $('.' + group, row);
  for (var delta in this.tableSettings[group]) {
    var targetClass = this.tableSettings[group][delta].target;
    if (field.is('.' + targetClass)) {
      // Return a copy of the row settings.
      var rowSettings = {};
      for (var n in this.tableSettings[group][delta]) {
        rowSettings[n] = this.tableSettings[group][delta][n];
      }
      return rowSettings;
    }
  }
};

/**
 * Take an item and add event handlers to make it become draggable.
 */
Drupal.tableDrag.prototype.makeDraggable = function (item) {
  var self = this;

  // Create the handle.
  var handle = $('<a href="#" class="tabledrag-handle"><div class="handle">&nbsp;</div></a>').attr('title', Drupal.t('Drag to re-order'));
  // Insert the handle after indentations (if any).
  if ($('td:first .indentation:last', item).length) {
    $('td:first .indentation:last', item).after(handle);
    // Update the total width of indentation in this entire table.
    self.indentCount = Math.max($('.indentation', item).length, self.indentCount);
  }
  else {
    $('td:first', item).prepend(handle);
  }

  // Add hover action for the handle.
  handle.hover(function () {
    self.dragObject == null ? $(this).addClass('tabledrag-handle-hover') : null;
  }, function () {
    self.dragObject == null ? $(this).removeClass('tabledrag-handle-hover') : null;
  });

  // Add the mousedown action for the handle.
  handle.mousedown(function (event) {
    // Create a new dragObject recording the event information.
    self.dragObject = {};
    self.dragObject.initMouseOffset = self.getMouseOffset(item, event);
    self.dragObject.initMouseCoords = self.mouseCoords(event);
    if (self.indentEnabled) {
      self.dragObject.indentMousePos = self.dragObject.initMouseCoords;
    }

    // If there's a lingering row object from the keyboard, remove its focus.
    if (self.rowObject) {
      $('a.tabledrag-handle', self.rowObject.element).blur();
    }

    // Create a new rowObject for manipulation of this row.
    self.rowObject = new self.row(item, 'mouse', self.indentEnabled, self.maxDepth, true);

    // Save the position of the table.
    self.table.topY = $(self.table).offset().top;
    self.table.bottomY = self.table.topY + self.table.offsetHeight;

    // Add classes to the handle and row.
    $(this).addClass('tabledrag-handle-hover');
    $(item).addClass('drag');

    // Set the document to use the move cursor during drag.
    $('body').addClass('drag');
    if (self.oldRowElement) {
      $(self.oldRowElement).removeClass('drag-previous');
    }

    // Hack for IE6 that flickers uncontrollably if select lists are moved.
    if (navigator.userAgent.indexOf('MSIE 6.') != -1) {
      $('select', this.table).css('display', 'none');
    }

    // Hack for Konqueror, prevent the blur handler from firing.
    // Konqueror always gives links focus, even after returning false on mousedown.
    self.safeBlur = false;

    // Call optional placeholder function.
    self.onDrag();
    return false;
  });

  // Prevent the anchor tag from jumping us to the top of the page.
  handle.click(function () {
    return false;
  });

  // Similar to the hover event, add a class when the handle is focused.
  handle.focus(function () {
    $(this).addClass('tabledrag-handle-hover');
    self.safeBlur = true;
  });

  // Remove the handle class on blur and fire the same function as a mouseup.
  handle.blur(function (event) {
    $(this).removeClass('tabledrag-handle-hover');
    if (self.rowObject && self.safeBlur) {
      self.dropRow(event, self);
    }
  });

  // Add arrow-key support to the handle.
  handle.keydown(function (event) {
    // If a rowObject doesn't yet exist and this isn't the tab key.
    if (event.keyCode != 9 && !self.rowObject) {
      self.rowObject = new self.row(item, 'keyboard', self.indentEnabled, self.maxDepth, true);
    }

    var keyChange = false;
    switch (event.keyCode) {
      case 37: // Left arrow.
      case 63234: // Safari left arrow.
        keyChange = true;
        self.rowObject.indent(-1 * self.rtl);
        break;
      case 38: // Up arrow.
      case 63232: // Safari up arrow.
        var previousRow = $(self.rowObject.element).prev('tr').get(0);
        while (previousRow && $(previousRow).is(':hidden')) {
          previousRow = $(previousRow).prev('tr').get(0);
        }
        if (previousRow) {
          self.safeBlur = false; // Do not allow the onBlur cleanup.
          self.rowObject.direction = 'up';
          keyChange = true;

          if ($(item).is('.tabledrag-root')) {
            // Swap with the previous top-level row.
            var groupHeight = 0;
            while (previousRow && $('.indentation', previousRow).length) {
              previousRow = $(previousRow).prev('tr').get(0);
              groupHeight += $(previousRow).is(':hidden') ? 0 : previousRow.offsetHeight;
            }
            if (previousRow) {
              self.rowObject.swap('before', previousRow);
              // No need to check for indentation, 0 is the only valid one.
              window.scrollBy(0, -groupHeight);
            }
          }
          else if (self.table.tBodies[0].rows[0] != previousRow || $(previousRow).is('.draggable')) {
            // Swap with the previous row (unless previous row is the first one
            // and undraggable).
            self.rowObject.swap('before', previousRow);
            self.rowObject.interval = null;
            self.rowObject.indent(0);
            window.scrollBy(0, -parseInt(item.offsetHeight, 10));
          }
          handle.get(0).focus(); // Regain focus after the DOM manipulation.
        }
        break;
      case 39: // Right arrow.
      case 63235: // Safari right arrow.
        keyChange = true;
        self.rowObject.indent(1 * self.rtl);
        break;
      case 40: // Down arrow.
      case 63233: // Safari down arrow.
        var nextRow = $(self.rowObject.group).filter(':last').next('tr').get(0);
        while (nextRow && $(nextRow).is(':hidden')) {
          nextRow = $(nextRow).next('tr').get(0);
        }
        if (nextRow) {
          self.safeBlur = false; // Do not allow the onBlur cleanup.
          self.rowObject.direction = 'down';
          keyChange = true;

          if ($(item).is('.tabledrag-root')) {
            // Swap with the next group (necessarily a top-level one).
            var groupHeight = 0;
            var nextGroup = new self.row(nextRow, 'keyboard', self.indentEnabled, self.maxDepth, false);
            if (nextGroup) {
              $(nextGroup.group).each(function () {
                groupHeight += $(this).is(':hidden') ? 0 : this.offsetHeight;
              });
              var nextGroupRow = $(nextGroup.group).filter(':last').get(0);
              self.rowObject.swap('after', nextGroupRow);
              // No need to check for indentation, 0 is the only valid one.
              window.scrollBy(0, parseInt(groupHeight, 10));
            }
          }
          else {
            // Swap with the next row.
            self.rowObject.swap('after', nextRow);
            self.rowObject.interval = null;
            self.rowObject.indent(0);
            window.scrollBy(0, parseInt(item.offsetHeight, 10));
          }
          handle.get(0).focus(); // Regain focus after the DOM manipulation.
        }
        break;
    }

    if (self.rowObject && self.rowObject.changed == true) {
      $(item).addClass('drag');
      if (self.oldRowElement) {
        $(self.oldRowElement).removeClass('drag-previous');
      }
      self.oldRowElement = item;
      self.restripeTable();
      self.onDrag();
    }

    // Returning false if we have an arrow key to prevent scrolling.
    if (keyChange) {
      return false;
    }
  });

  // Compatibility addition, return false on keypress to prevent unwanted scrolling.
  // IE and Safari will suppress scrolling on keydown, but all other browsers
  // need to return false on keypress. http://www.quirksmode.org/js/keys.html
  handle.keypress(function (event) {
    switch (event.keyCode) {
      case 37: // Left arrow.
      case 38: // Up arrow.
      case 39: // Right arrow.
      case 40: // Down arrow.
        return false;
    }
  });
};

/**
 * Mousemove event handler, bound to document.
 */
Drupal.tableDrag.prototype.dragRow = function (event, self) {
  if (self.dragObject) {
    self.currentMouseCoords = self.mouseCoords(event);

    var y = self.currentMouseCoords.y - self.dragObject.initMouseOffset.y;
    var x = self.currentMouseCoords.x - self.dragObject.initMouseOffset.x;

    // Check for row swapping and vertical scrolling.
    if (y != self.oldY) {
      self.rowObject.direction = y > self.oldY ? 'down' : 'up';
      self.oldY = y; // Update the old value.

      // Check if the window should be scrolled (and how fast).
      var scrollAmount = self.checkScroll(self.currentMouseCoords.y);
      // Stop any current scrolling.
      clearInterval(self.scrollInterval);
      // Continue scrolling if the mouse has moved in the scroll direction.
      if (scrollAmount > 0 && self.rowObject.direction == 'down' || scrollAmount < 0 && self.rowObject.direction == 'up') {
        self.setScroll(scrollAmount);
      }

      // If we have a valid target, perform the swap and restripe the table.
      var currentRow = self.findDropTargetRow(x, y);
      if (currentRow) {
        if (self.rowObject.direction == 'down') {
          self.rowObject.swap('after', currentRow, self);
        }
        else {
          self.rowObject.swap('before', currentRow, self);
        }
        self.restripeTable();
      }
    }

    // Similar to row swapping, handle indentations.
    if (self.indentEnabled) {
      var xDiff = self.currentMouseCoords.x - self.dragObject.indentMousePos.x;
      // Set the number of indentations the mouse has been moved left or right.
      var indentDiff = Math.round(xDiff / self.indentAmount);
      // Indent the row with our estimated diff, which may be further
      // restricted according to the rows around this row.
      var indentChange = self.rowObject.indent(indentDiff);
      // Update table and mouse indentations.
      self.dragObject.indentMousePos.x += self.indentAmount * indentChange * self.rtl;
      self.indentCount = Math.max(self.indentCount, self.rowObject.indents);
    }

    return false;
  }
};

/**
 * Mouseup event handler, bound to document.
 * Blur event handler, bound to drag handle for keyboard support.
 */
Drupal.tableDrag.prototype.dropRow = function (event, self) {
  // Drop row functionality shared between mouseup and blur events.
  if (self.rowObject != null) {
    var droppedRow = self.rowObject.element;
    // The row is already in the right place so we just release it.
    if (self.rowObject.changed == true) {
      // Update the fields in the dropped row.
      self.updateFields(droppedRow);

      // If a setting exists for affecting the entire group, update all the
      // fields in the entire dragged group.
      for (var group in self.tableSettings) {
        var rowSettings = self.rowSettings(group, droppedRow);
        if (rowSettings.relationship == 'group') {
          for (var n in self.rowObject.children) {
            self.updateField(self.rowObject.children[n], group);
          }
        }
      }

      self.rowObject.markChanged();
      if (self.changed == false) {
        $(Drupal.theme('tableDragChangedWarning')).insertBefore(self.table).hide().fadeIn('slow');
        self.changed = true;
      }
    }

    if (self.indentEnabled) {
      self.rowObject.removeIndentClasses();
    }
    if (self.oldRowElement) {
      $(self.oldRowElement).removeClass('drag-previous');
    }
    $(droppedRow).removeClass('drag').addClass('drag-previous');
    self.oldRowElement = droppedRow;
    self.onDrop();
    self.rowObject = null;
  }

  // Functionality specific only to mouseup event.
  if (self.dragObject != null) {
    $('.tabledrag-handle', droppedRow).removeClass('tabledrag-handle-hover');

    self.dragObject = null;
    $('body').removeClass('drag');
    clearInterval(self.scrollInterval);

    // Hack for IE6 that flickers uncontrollably if select lists are moved.
    if (navigator.userAgent.indexOf('MSIE 6.') != -1) {
      $('select', this.table).css('display', 'block');
    }
  }
};

/**
 * Get the mouse coordinates from the event (allowing for browser differences).
 */
Drupal.tableDrag.prototype.mouseCoords = function (event) {
  if (event.pageX || event.pageY) {
    return { x: event.pageX, y: event.pageY };
  }
  return {
    x: event.clientX + document.body.scrollLeft - document.body.clientLeft,
    y: event.clientY + document.body.scrollTop  - document.body.clientTop
  };
};

/**
 * Given a target element and a mouse event, get the mouse offset from that
 * element. To do this we need the element's position and the mouse position.
 */
Drupal.tableDrag.prototype.getMouseOffset = function (target, event) {
  var docPos   = $(target).offset();
  var mousePos = this.mouseCoords(event);
  return { x: mousePos.x - docPos.left, y: mousePos.y - docPos.top };
};

/**
 * Find the row the mouse is currently over. This row is then taken and swapped
 * with the one being dragged.
 *
 * @param x
 *   The x coordinate of the mouse on the page (not the screen).
 * @param y
 *   The y coordinate of the mouse on the page (not the screen).
 */
Drupal.tableDrag.prototype.findDropTargetRow = function (x, y) {
  var rows = $(this.table.tBodies[0].rows).not(':hidden');
  for (var n = 0; n < rows.length; n++) {
    var row = rows[n];
    var indentDiff = 0;
    var rowY = $(row).offset().top;
    // Because Safari does not report offsetHeight on table rows, but does on
    // table cells, grab the firstChild of the row and use that instead.
    // http://jacob.peargrove.com/blog/2006/technical/table-row-offsettop-bug-in-safari.
    if (row.offsetHeight == 0) {
      var rowHeight = parseInt(row.firstChild.offsetHeight, 10) / 2;
    }
    // Other browsers.
    else {
      var rowHeight = parseInt(row.offsetHeight, 10) / 2;
    }

    // Because we always insert before, we need to offset the height a bit.
    if ((y > (rowY - rowHeight)) && (y < (rowY + rowHeight))) {
      if (this.indentEnabled) {
        // Check that this row is not a child of the row being dragged.
        for (var n in this.rowObject.group) {
          if (this.rowObject.group[n] == row) {
            return null;
          }
        }
      }
      else {
        // Do not allow a row to be swapped with itself.
        if (row == this.rowObject.element) {
          return null;
        }
      }

      // Check that swapping with this row is allowed.
      if (!this.rowObject.isValidSwap(row)) {
        return null;
      }

      // We may have found the row the mouse just passed over, but it doesn't
      // take into account hidden rows. Skip backwards until we find a draggable
      // row.
      while ($(row).is(':hidden') && $(row).prev('tr').is(':hidden')) {
        row = $(row).prev('tr').get(0);
      }
      return row;
    }
  }
  return null;
};

/**
 * After the row is dropped, update the table fields according to the settings
 * set for this table.
 *
 * @param changedRow
 *   DOM object for the row that was just dropped.
 */
Drupal.tableDrag.prototype.updateFields = function (changedRow) {
  for (var group in this.tableSettings) {
    // Each group may have a different setting for relationship, so we find
    // the source rows for each separately.
    this.updateField(changedRow, group);
  }
};

/**
 * After the row is dropped, update a single table field according to specific
 * settings.
 *
 * @param changedRow
 *   DOM object for the row that was just dropped.
 * @param group
 *   The settings group on which field updates will occur.
 */
Drupal.tableDrag.prototype.updateField = function (changedRow, group) {
  var rowSettings = this.rowSettings(group, changedRow);

  // Set the row as its own target.
  if (rowSettings.relationship == 'self' || rowSettings.relationship == 'group') {
    var sourceRow = changedRow;
  }
  // Siblings are easy, check previous and next rows.
  else if (rowSettings.relationship == 'sibling') {
    var previousRow = $(changedRow).prev('tr').get(0);
    var nextRow = $(changedRow).next('tr').get(0);
    var sourceRow = changedRow;
    if ($(previousRow).is('.draggable') && $('.' + group, previousRow).length) {
      if (this.indentEnabled) {
        if ($('.indentations', previousRow).length == $('.indentations', changedRow)) {
          sourceRow = previousRow;
        }
      }
      else {
        sourceRow = previousRow;
      }
    }
    else if ($(nextRow).is('.draggable') && $('.' + group, nextRow).length) {
      if (this.indentEnabled) {
        if ($('.indentations', nextRow).length == $('.indentations', changedRow)) {
          sourceRow = nextRow;
        }
      }
      else {
        sourceRow = nextRow;
      }
    }
  }
  // Parents, look up the tree until we find a field not in this group.
  // Go up as many parents as indentations in the changed row.
  else if (rowSettings.relationship == 'parent') {
    var previousRow = $(changedRow).prev('tr');
    while (previousRow.length && $('.indentation', previousRow).length >= this.rowObject.indents) {
      previousRow = previousRow.prev('tr');
    }
    // If we found a row.
    if (previousRow.length) {
      sourceRow = previousRow[0];
    }
    // Otherwise we went all the way to the left of the table without finding
    // a parent, meaning this item has been placed at the root level.
    else {
      // Use the first row in the table as source, because it's guaranteed to
      // be at the root level. Find the first item, then compare this row
      // against it as a sibling.
      sourceRow = $(this.table).find('tr.draggable:first').get(0);
      if (sourceRow == this.rowObject.element) {
        sourceRow = $(this.rowObject.group[this.rowObject.group.length - 1]).next('tr.draggable').get(0);
      }
      var useSibling = true;
    }
  }

  // Because we may have moved the row from one category to another,
  // take a look at our sibling and borrow its sources and targets.
  this.copyDragClasses(sourceRow, changedRow, group);
  rowSettings = this.rowSettings(group, changedRow);

  // In the case that we're looking for a parent, but the row is at the top
  // of the tree, copy our sibling's values.
  if (useSibling) {
    rowSettings.relationship = 'sibling';
    rowSettings.source = rowSettings.target;
  }

  var targetClass = '.' + rowSettings.target;
  var targetElement = $(targetClass, changedRow).get(0);

  // Check if a target element exists in this row.
  if (targetElement) {
    var sourceClass = '.' + rowSettings.source;
    var sourceElement = $(sourceClass, sourceRow).get(0);
    switch (rowSettings.action) {
      case 'depth':
        // Get the depth of the target row.
        targetElement.value = $('.indentation', $(sourceElement).closest('tr')).length;
        break;
      case 'match':
        // Update the value.
        targetElement.value = sourceElement.value;
        break;
      case 'order':
        var siblings = this.rowObject.findSiblings(rowSettings);
        if ($(targetElement).is('select')) {
          // Get a list of acceptable values.
          var values = [];
          $('option', targetElement).each(function () {
            values.push(this.value);
          });
          var maxVal = values[values.length - 1];
          // Populate the values in the siblings.
          $(targetClass, siblings).each(function () {
            // If there are more items than possible values, assign the maximum value to the row.
            if (values.length > 0) {
              this.value = values.shift();
            }
            else {
              this.value = maxVal;
            }
          });
        }
        else {
          // Assume a numeric input field.
          var weight = parseInt($(targetClass, siblings[0]).val(), 10) || 0;
          $(targetClass, siblings).each(function () {
            this.value = weight;
            weight++;
          });
        }
        break;
    }
  }
};

/**
 * Copy all special tableDrag classes from one row's form elements to a
 * different one, removing any special classes that the destination row
 * may have had.
 */
Drupal.tableDrag.prototype.copyDragClasses = function (sourceRow, targetRow, group) {
  var sourceElement = $('.' + group, sourceRow);
  var targetElement = $('.' + group, targetRow);
  if (sourceElement.length && targetElement.length) {
    targetElement[0].className = sourceElement[0].className;
  }
};

Drupal.tableDrag.prototype.checkScroll = function (cursorY) {
  var de  = document.documentElement;
  var b  = document.body;

  var windowHeight = this.windowHeight = window.innerHeight || (de.clientHeight && de.clientWidth != 0 ? de.clientHeight : b.offsetHeight);
  var scrollY = this.scrollY = (document.all ? (!de.scrollTop ? b.scrollTop : de.scrollTop) : (window.pageYOffset ? window.pageYOffset : window.scrollY));
  var trigger = this.scrollSettings.trigger;
  var delta = 0;

  // Return a scroll speed relative to the edge of the screen.
  if (cursorY - scrollY > windowHeight - trigger) {
    delta = trigger / (windowHeight + scrollY - cursorY);
    delta = (delta > 0 && delta < trigger) ? delta : trigger;
    return delta * this.scrollSettings.amount;
  }
  else if (cursorY - scrollY < trigger) {
    delta = trigger / (cursorY - scrollY);
    delta = (delta > 0 && delta < trigger) ? delta : trigger;
    return -delta * this.scrollSettings.amount;
  }
};

Drupal.tableDrag.prototype.setScroll = function (scrollAmount) {
  var self = this;

  this.scrollInterval = setInterval(function () {
    // Update the scroll values stored in the object.
    self.checkScroll(self.currentMouseCoords.y);
    var aboveTable = self.scrollY > self.table.topY;
    var belowTable = self.scrollY + self.windowHeight < self.table.bottomY;
    if (scrollAmount > 0 && belowTable || scrollAmount < 0 && aboveTable) {
      window.scrollBy(0, scrollAmount);
    }
  }, this.scrollSettings.interval);
};

Drupal.tableDrag.prototype.restripeTable = function () {
  // :even and :odd are reversed because jQuery counts from 0 and
  // we count from 1, so we're out of sync.
  // Match immediate children of the parent element to allow nesting.
  $('> tbody > tr.draggable:visible, > tr.draggable:visible', this.table)
    .removeClass('odd even')
    .filter(':odd').addClass('even').end()
    .filter(':even').addClass('odd');
};

/**
 * Stub function. Allows a custom handler when a row begins dragging.
 */
Drupal.tableDrag.prototype.onDrag = function () {
  return null;
};

/**
 * Stub function. Allows a custom handler when a row is dropped.
 */
Drupal.tableDrag.prototype.onDrop = function () {
  return null;
};

/**
 * Constructor to make a new object to manipulate a table row.
 *
 * @param tableRow
 *   The DOM element for the table row we will be manipulating.
 * @param method
 *   The method in which this row is being moved. Either 'keyboard' or 'mouse'.
 * @param indentEnabled
 *   Whether the containing table uses indentations. Used for optimizations.
 * @param maxDepth
 *   The maximum amount of indentations this row may contain.
 * @param addClasses
 *   Whether we want to add classes to this row to indicate child relationships.
 */
Drupal.tableDrag.prototype.row = function (tableRow, method, indentEnabled, maxDepth, addClasses) {
  this.element = tableRow;
  this.method = method;
  this.group = [tableRow];
  this.groupDepth = $('.indentation', tableRow).length;
  this.changed = false;
  this.table = $(tableRow).closest('table').get(0);
  this.indentEnabled = indentEnabled;
  this.maxDepth = maxDepth;
  this.direction = ''; // Direction the row is being moved.

  if (this.indentEnabled) {
    this.indents = $('.indentation', tableRow).length;
    this.children = this.findChildren(addClasses);
    this.group = $.merge(this.group, this.children);
    // Find the depth of this entire group.
    for (var n = 0; n < this.group.length; n++) {
      this.groupDepth = Math.max($('.indentation', this.group[n]).length, this.groupDepth);
    }
  }
};

/**
 * Find all children of rowObject by indentation.
 *
 * @param addClasses
 *   Whether we want to add classes to this row to indicate child relationships.
 */
Drupal.tableDrag.prototype.row.prototype.findChildren = function (addClasses) {
  var parentIndentation = this.indents;
  var currentRow = $(this.element, this.table).next('tr.draggable');
  var rows = [];
  var child = 0;
  while (currentRow.length) {
    var rowIndentation = $('.indentation', currentRow).length;
    // A greater indentation indicates this is a child.
    if (rowIndentation > parentIndentation) {
      child++;
      rows.push(currentRow[0]);
      if (addClasses) {
        $('.indentation', currentRow).each(function (indentNum) {
          if (child == 1 && (indentNum == parentIndentation)) {
            $(this).addClass('tree-child-first');
          }
          if (indentNum == parentIndentation) {
            $(this).addClass('tree-child');
          }
          else if (indentNum > parentIndentation) {
            $(this).addClass('tree-child-horizontal');
          }
        });
      }
    }
    else {
      break;
    }
    currentRow = currentRow.next('tr.draggable');
  }
  if (addClasses && rows.length) {
    $('.indentation:nth-child(' + (parentIndentation + 1) + ')', rows[rows.length - 1]).addClass('tree-child-last');
  }
  return rows;
};

/**
 * Ensure that two rows are allowed to be swapped.
 *
 * @param row
 *   DOM object for the row being considered for swapping.
 */
Drupal.tableDrag.prototype.row.prototype.isValidSwap = function (row) {
  if (this.indentEnabled) {
    var prevRow, nextRow;
    if (this.direction == 'down') {
      prevRow = row;
      nextRow = $(row).next('tr').get(0);
    }
    else {
      prevRow = $(row).prev('tr').get(0);
      nextRow = row;
    }
    this.interval = this.validIndentInterval(prevRow, nextRow);

    // We have an invalid swap if the valid indentations interval is empty.
    if (this.interval.min > this.interval.max) {
      return false;
    }
  }

  // Do not let an un-draggable first row have anything put before it.
  if (this.table.tBodies[0].rows[0] == row && $(row).is(':not(.draggable)')) {
    return false;
  }

  return true;
};

/**
 * Perform the swap between two rows.
 *
 * @param position
 *   Whether the swap will occur 'before' or 'after' the given row.
 * @param row
 *   DOM element what will be swapped with the row group.
 */
Drupal.tableDrag.prototype.row.prototype.swap = function (position, row) {
  Drupal.detachBehaviors(this.group, Drupal.settings, 'move');
  $(row)[position](this.group);
  Drupal.attachBehaviors(this.group, Drupal.settings);
  this.changed = true;
  this.onSwap(row);
};

/**
 * Determine the valid indentations interval for the row at a given position
 * in the table.
 *
 * @param prevRow
 *   DOM object for the row before the tested position
 *   (or null for first position in the table).
 * @param nextRow
 *   DOM object for the row after the tested position
 *   (or null for last position in the table).
 */
Drupal.tableDrag.prototype.row.prototype.validIndentInterval = function (prevRow, nextRow) {
  var minIndent, maxIndent;

  // Minimum indentation:
  // Do not orphan the next row.
  minIndent = nextRow ? $('.indentation', nextRow).length : 0;

  // Maximum indentation:
  if (!prevRow || $(prevRow).is(':not(.draggable)') || $(this.element).is('.tabledrag-root')) {
    // Do not indent:
    // - the first row in the table,
    // - rows dragged below a non-draggable row,
    // - 'root' rows.
    maxIndent = 0;
  }
  else {
    // Do not go deeper than as a child of the previous row.
    maxIndent = $('.indentation', prevRow).length + ($(prevRow).is('.tabledrag-leaf') ? 0 : 1);
    // Limit by the maximum allowed depth for the table.
    if (this.maxDepth) {
      maxIndent = Math.min(maxIndent, this.maxDepth - (this.groupDepth - this.indents));
    }
  }

  return { 'min': minIndent, 'max': maxIndent };
};

/**
 * Indent a row within the legal bounds of the table.
 *
 * @param indentDiff
 *   The number of additional indentations proposed for the row (can be
 *   positive or negative). This number will be adjusted to nearest valid
 *   indentation level for the row.
 */
Drupal.tableDrag.prototype.row.prototype.indent = function (indentDiff) {
  // Determine the valid indentations interval if not available yet.
  if (!this.interval) {
    var prevRow = $(this.element).prev('tr').get(0);
    var nextRow = $(this.group).filter(':last').next('tr').get(0);
    this.interval = this.validIndentInterval(prevRow, nextRow);
  }

  // Adjust to the nearest valid indentation.
  var indent = this.indents + indentDiff;
  indent = Math.max(indent, this.interval.min);
  indent = Math.min(indent, this.interval.max);
  indentDiff = indent - this.indents;

  for (var n = 1; n <= Math.abs(indentDiff); n++) {
    // Add or remove indentations.
    if (indentDiff < 0) {
      $('.indentation:first', this.group).remove();
      this.indents--;
    }
    else {
      $('td:first', this.group).prepend(Drupal.theme('tableDragIndentation'));
      this.indents++;
    }
  }
  if (indentDiff) {
    // Update indentation for this row.
    this.changed = true;
    this.groupDepth += indentDiff;
    this.onIndent();
  }

  return indentDiff;
};

/**
 * Find all siblings for a row, either according to its subgroup or indentation.
 * Note that the passed-in row is included in the list of siblings.
 *
 * @param settings
 *   The field settings we're using to identify what constitutes a sibling.
 */
Drupal.tableDrag.prototype.row.prototype.findSiblings = function (rowSettings) {
  var siblings = [];
  var directions = ['prev', 'next'];
  var rowIndentation = this.indents;
  for (var d = 0; d < directions.length; d++) {
    var checkRow = $(this.element)[directions[d]]();
    while (checkRow.length) {
      // Check that the sibling contains a similar target field.
      if ($('.' + rowSettings.target, checkRow)) {
        // Either add immediately if this is a flat table, or check to ensure
        // that this row has the same level of indentation.
        if (this.indentEnabled) {
          var checkRowIndentation = $('.indentation', checkRow).length;
        }

        if (!(this.indentEnabled) || (checkRowIndentation == rowIndentation)) {
          siblings.push(checkRow[0]);
        }
        else if (checkRowIndentation < rowIndentation) {
          // No need to keep looking for siblings when we get to a parent.
          break;
        }
      }
      else {
        break;
      }
      checkRow = $(checkRow)[directions[d]]();
    }
    // Since siblings are added in reverse order for previous, reverse the
    // completed list of previous siblings. Add the current row and continue.
    if (directions[d] == 'prev') {
      siblings.reverse();
      siblings.push(this.element);
    }
  }
  return siblings;
};

/**
 * Remove indentation helper classes from the current row group.
 */
Drupal.tableDrag.prototype.row.prototype.removeIndentClasses = function () {
  for (var n in this.children) {
    $('.indentation', this.children[n])
      .removeClass('tree-child')
      .removeClass('tree-child-first')
      .removeClass('tree-child-last')
      .removeClass('tree-child-horizontal');
  }
};

/**
 * Add an asterisk or other marker to the changed row.
 */
Drupal.tableDrag.prototype.row.prototype.markChanged = function () {
  var marker = Drupal.theme('tableDragChangedMarker');
  var cell = $('td:first', this.element);
  if ($('span.tabledrag-changed', cell).length == 0) {
    cell.append(marker);
  }
};

/**
 * Stub function. Allows a custom handler when a row is indented.
 */
Drupal.tableDrag.prototype.row.prototype.onIndent = function () {
  return null;
};

/**
 * Stub function. Allows a custom handler when a row is swapped.
 */
Drupal.tableDrag.prototype.row.prototype.onSwap = function (swappedRow) {
  return null;
};

Drupal.theme.prototype.tableDragChangedMarker = function () {
  return '<span class="warning tabledrag-changed">*</span>';
};

Drupal.theme.prototype.tableDragIndentation = function () {
  return '<div class="indentation">&nbsp;</div>';
};

Drupal.theme.prototype.tableDragChangedWarning = function () {
  return '<div class="tabledrag-changed-warning messages warning">' + Drupal.theme('tableDragChangedMarker') + ' ' + Drupal.t('Changes made in this table will not be saved until the form is submitted.') + '</div>';
};

})(jQuery);
;
Drupal.locale = { 'pluralFormula': function ($n) { return Number(($n!=1)); }, 'strings': {"":{"Next":"Siguiente","Disabled":"Desactivado","Enabled":"Activado","Edit":"Editar","Sunday":"Domingo","Monday":"Lunes","Tuesday":"Martes","Wednesday":"Mi\u00e9rcoles","Thursday":"Jueves","Friday":"Viernes","Saturday":"S\u00e1bado","Add":"Agregar","Configure":"Configurar"}} };;
(function ($) {

/**
 * Attaches double-click behavior to toggle full path of Krumo elements.
 */
Drupal.behaviors.devel = {
  attach: function (context, settings) {

    // Add hint to footnote
    $('.krumo-footnote .krumo-call').once().before('<img style="vertical-align: middle;" title="Click to expand. Double-click to show path." src="' + settings.basePath + 'misc/help.png"/>');

    var krumo_name = [];
    var krumo_type = [];

    function krumo_traverse(el) {
      krumo_name.push($(el).html());
      krumo_type.push($(el).siblings('em').html().match(/\w*/)[0]);

      if ($(el).closest('.krumo-nest').length > 0) {
        krumo_traverse($(el).closest('.krumo-nest').prev().find('.krumo-name'));
      }
    }

    $('.krumo-child > div:first-child', context).dblclick(
      function(e) {
        if ($(this).find('> .krumo-php-path').length > 0) {
          // Remove path if shown.
          $(this).find('> .krumo-php-path').remove();
        }
        else {
          // Get elements.
          krumo_traverse($(this).find('> a.krumo-name'));

          // Create path.
          var krumo_path_string = '';
          for (var i = krumo_name.length - 1; i >= 0; --i) {
            // Start element.
            if ((krumo_name.length - 1) == i)
              krumo_path_string += '$' + krumo_name[i];

            if (typeof krumo_name[(i-1)] !== 'undefined') {
              if (krumo_type[i] == 'Array') {
                krumo_path_string += "[";
                if (!/^\d*$/.test(krumo_name[(i-1)]))
                  krumo_path_string += "'";
                krumo_path_string += krumo_name[(i-1)];
                if (!/^\d*$/.test(krumo_name[(i-1)]))
                  krumo_path_string += "'";
                krumo_path_string += "]";
              }
              if (krumo_type[i] == 'Object')
                krumo_path_string += '->' + krumo_name[(i-1)];
            }
          }
          $(this).append('<div class="krumo-php-path" style="font-family: Courier, monospace; font-weight: bold;">' + krumo_path_string + '</div>');

          // Reset arrays.
          krumo_name = [];
          krumo_type = [];
        }
      }
    );
  }
};

})(jQuery);
;
/**
 * Attaches the calendar behavior to all required fields
 */
(function($) {
  function makeFocusHandler(e) {
    if (!$(this).hasClass('date-popup-init')) {
      var datePopup = e.data;
      // Explicitely filter the methods we accept.
      switch (datePopup.func) {
        case 'datepicker':
          $(this)
            .datepicker(datePopup.settings)
            .addClass('date-popup-init');
          $(this).click(function(){
            $(this).focus();
          });
          break;

        case 'timeEntry':
          $(this)
            .timeEntry(datePopup.settings)
            .addClass('date-popup-init');
          $(this).click(function(){
            $(this).focus();
          });
          break;

        case 'timepicker':
          // Translate the PHP date format into the style the timepicker uses.
          datePopup.settings.timeFormat = datePopup.settings.timeFormat
            // 12-hour, leading zero,
            .replace('h', 'hh')
            // 12-hour, no leading zero.
            .replace('g', 'h')
            // 24-hour, leading zero.
            .replace('H', 'HH')
            // 24-hour, no leading zero.
            .replace('G', 'H')
            // AM/PM.
            .replace('A', 'p')
            // Minutes with leading zero.
            .replace('i', 'mm')
            // Seconds with leading zero.
            .replace('s', 'ss');

          datePopup.settings.startTime = new Date(datePopup.settings.startTime);
          $(this)
            .timepicker(datePopup.settings)
            .addClass('date-popup-init');
          $(this).click(function(){
            $(this).focus();
          });
          break;
      }
    }
  }

  Drupal.behaviors.date_popup = {
    attach: function (context) {
      for (var id in Drupal.settings.datePopup) {
        $('#'+ id).bind('focus', Drupal.settings.datePopup[id], makeFocusHandler);
      }
    }
  };
})(jQuery);
;
/**
 * JavaScript file that handles initializing and firing the Yoast
 * js-text-analysis library.
 */
(function ($) {
  Drupal.yoast_seo = Drupal.yoast_seo || {};

  Drupal.behaviors.yoast_seo = {
    attach: function (context, settings) {
      // Making sure we actually have data.
      if (typeof settings.yoast_seo != 'undefined') {
        // Making sure we only initiate Yoast SEO once.
        $('body', context).once('yoast_seo', function() {
          YoastSEO.analyzerArgs = {
            source: YoastSEO_DrupalSource,
            analyzer: settings.yoast_seo.analyzer,
            snippetPreview: settings.yoast_seo.snippetPreview,
            elementTarget: [settings.yoast_seo.targetId],
            typeDelay: 300,
            typeDelayStep: 100,
            maxTypeDelay: 1500,
            dynamicDelay: true,
            multiKeyword: false,
            targets: {
              output: settings.yoast_seo.targets.output,
              overall: settings.yoast_seo.targets.overall,
              snippet: settings.yoast_seo.targets.snippet
            },
            snippetFields: {
              title: "snippet_title",
              url: "snippet_cite",
              meta: "snippet_meta"
            },
            sampleText: {
              url: settings.yoast_seo.defaultText.url,
              title: settings.yoast_seo.defaultText.title,
              keyword: settings.yoast_seo.defaultText.keyword,
              meta: settings.yoast_seo.defaultText.meta,
              text: settings.yoast_seo.defaultText.body
            },
            fields: {
              keyword: settings.yoast_seo.fields.focusKeyword,
              title: settings.yoast_seo.fields.pageTitle,
              nodeTitle: settings.yoast_seo.fields.nodeTitle,
              meta: settings.yoast_seo.fields.description,
              text: settings.yoast_seo.fields.bodyText,
              url: settings.yoast_seo.fields.url
            },
            placeholderText: {
              title: settings.yoast_seo.placeholderText.title,
              description: settings.yoast_seo.placeholderText.description,
              url: settings.yoast_seo.placeholderText.url
            },
            SEOTitleOverwritten: settings.yoast_seo.SEOTitleOverwritten,
            scoreElement: settings.yoast_seo.fields.seoStatus,
            baseRoot: settings.yoast_seo.baseRoot
          };

          // Create a new Yoast SEO instance.
          if (typeof YoastSEO != "undefined") {
            var DrupalSource = new YoastSEO_DrupalSource(YoastSEO.analyzerArgs);

            // Declaring the callback functions, for now we bind DrupalSource.
            YoastSEO.analyzerArgs.callbacks = {
              getData: DrupalSource.getData.bind(DrupalSource),
              getAnalyzerInput: DrupalSource.getAnalyzerInput.bind(DrupalSource),
              bindElementEvents: DrupalSource.bindElementEvents.bind(DrupalSource),
              updateSnippetValues: DrupalSource.updateSnippetValues.bind(DrupalSource),
              saveScores: DrupalSource.saveScores.bind(DrupalSource)
            };

            // Make it global.
            window.YoastSEO.app = new YoastSEO.App( YoastSEO.analyzerArgs );

            // Parse the input from snippet preview fields to their corresponding metatag and path fields
            DrupalSource.parseSnippetData( YoastSEO.analyzerArgs.snippetFields.title, YoastSEO.analyzerArgs.fields.title );
            DrupalSource.parseSnippetData( YoastSEO.analyzerArgs.snippetFields.url, YoastSEO.analyzerArgs.fields.url );
            DrupalSource.parseSnippetData( YoastSEO.analyzerArgs.snippetFields.meta, YoastSEO.analyzerArgs.fields.meta );

            // No enter on contenteditable fields.
            $("#snippet_title, #snippet_cite, #snippet_meta").keypress(function(e) {
              if (e.keyCode == 13) {
                e.preventDefault();
              }
            });

            // Check for CKEditor instances, with a max of 2500ms(= 25ms * 100).
            var maxDetectTries = 100;
            detectCKEditorInstances();

            // If we have multiple text formats we have to detect the CKEditor
            // on several occasions.
            if (settings.yoast_seo.textFormat) {
              // On text format change detect any CKEditor instances, if
              // applicable ofcourse.
              $('#' + settings.yoast_seo.textFormat).change(function() {
                maxDetectTries = 100;
                detectCKEditorInstances();
              });

              // Detect CKEditor on 'switch to rich text editor' link click.
              $('#' + settings.yoast_seo.textFormat).siblings('.ckeditor_links').click(function() {
                maxDetectTries = 100;
                detectCKEditorInstances();
              });
            }

            // Simple function to detect CKEditor instances for the body field.
            function detectCKEditorInstances() {
              var detected = false;
              if (typeof CKEDITOR != "undefined" && CKEDITOR.instances.length != 0 && maxDetectTries > 0) {
                if (typeof CKEDITOR.instances[YoastSEO.analyzerArgs.fields.text] != "undefined") {
                  detected = true;
                  // On any change in the CKEditor instance we set the value of
                  // the CKEditor instance back into the textarea. At that point
                  // we also fire a new input event.
                  CKEDITOR.instances[YoastSEO.analyzerArgs.fields.text].on('change', function() {
                    document.getElementById(YoastSEO.analyzerArgs.fields.text).value = CKEDITOR.instances[YoastSEO.analyzerArgs.fields.text].getData();
                    // Dispatch input event so Yoast SEO knows something changed!
                    DrupalSource.triggerEvent(YoastSEO.analyzerArgs.fields.text);
                  });
                }
              }

              // Retry if we haven't been able to detect a CKEditor yet.
              if (!detected && maxDetectTries > 0) {
                maxDetectTries--;
                setTimeout(detectCKEditorInstances, 25);
              }
            };
          }
          else {
            $('#' + settings.yoast_seo.targets.output).html('<p><strong>' + Drupal.t('It looks like something went wrong when we tried to load the Yoast SEO content analysis library. Please check it the module is installed correctly.') + '</strong></p>');
          }
        });
      }
    }
  }
})(jQuery);

/**
 * Inputgenerator generates a form for use as input.
 * @param args
 * @param refObj
 * @constructor
 */
YoastSEO_DrupalSource = function(args) {
  this.config = args;
  this.refObj = {};
  this.analyzerData = {};
  this.formattedData = {};
};

/**
 * Sets field value and dispatches an event to fire content analysis magic
 * @param field
 */
YoastSEO_DrupalSource.prototype.triggerEvent = function(field) {
  if ("createEvent" in document) {
    var ev = document.createEvent("HTMLEvents");
    ev.initEvent("input", false, true);
    document.getElementById(field).dispatchEvent(ev);
  }
  else {
    document.getElementById(field).fireEvent("input");
  }
}

/**
 * Parses the input in snippet preview fields on input evt to data in the metatag and path fields
 * @param source
 * @param target
 */
YoastSEO_DrupalSource.prototype.parseSnippetData = function(source, target) {
  var listener = function ( ev ) {
    document.getElementById(target).value = ev.target.innerText;
    this.triggerEvent(target);
  }.bind(this);
  document.getElementById(source).addEventListener("blur", listener);
}


/**
 * Grabs data from the refObj and returns populated analyzerData
 * @returns analyzerData
 */
YoastSEO_DrupalSource.prototype.getData = function() {
  // Default data in here.
  data = {
    keyword: this.getDataFromInput( "keyword" ),
    meta: this.getDataFromInput( "meta" ),
    snippetMeta: this.getDataFromInput( "meta" ),
    text: this.getDataFromInput( "text" ),
    snippetTitle: this.getDataFromInput( "title" ),
    pageTitle: this.getDataFromInput( "title" ),
    baseUrl: this.config.baseRoot + '/',
    url: this.config.baseRoot + '/' + this.getDataFromInput( "url" ),
    snippetCite: this.getDataFromInput( "url" )
  };

  // Placeholder text in snippet if nothing was found.
  if (data.meta == '') {
    data.snippetMeta = this.config.placeholderText.description;
  }
  if (data.pageTitle == '') {
    data.snippetTitle = this.config.placeholderText.title;
  }
  if (data.snippetCite == '') {
    data.snippetCite = this.config.placeholderText.url;
  }

  return data;
};

/**
 * Initializes the snippetPreview if it isn't there.
 * If it is already initialized, it get's new values from the inputs and rerenders snippet.
 */
YoastSEO_DrupalSource.prototype.getAnalyzerInput = function() {
  if (typeof YoastSEO.app.snippetPreview === "undefined") {
    YoastSEO.app.init();
  }
  else {
    this.updateRawData();
    YoastSEO.app.reloadSnippetText();
  }
  YoastSEO.app.runAnalyzerCallback();
};

YoastSEO_DrupalSource.prototype.getDataFromInput = function( field ) {
  return document.getElementById(this.config.fields[field]).value;
}

/**
 * Grabs data from the refObj and returns populated analyzerData
 * @returns analyzerData
 */
YoastSEO_DrupalSource.prototype.updateRawData = function() {
  data = {
    keyword: this.getDataFromInput( "keyword" ),
    meta: this.getDataFromInput( "meta" ),
    snippetMeta: this.getDataFromInput( "meta" ),
    text: this.getDataFromInput( "text" ),
    nodeTitle: this.getDataFromInput( "nodeTitle" ),
    snippetTitle: this.getDataFromInput( "title" ),
    pageTitle: this.getDataFromInput( "title" ),
    baseUrl: this.config.baseRoot + '/',
    url: this.config.baseRoot + '/' + this.getDataFromInput( "url" ),
    snippetCite: this.getDataFromInput( "url" )
  };

  if (!this.config.SEOTitleOverwritten) {
    data.pageTitle = data.nodeTitle;
    data.snippetTitle = data.nodeTitle;

    document.getElementById(this.config.fields.title).value = data.nodeTitle;
  }

  // Placeholder text in snippet if nothing was found.
  if (data.meta == '') {
    data.snippetMeta = this.config.placeholderText.description;
  }
  if (data.pageTitle == '') {
    data.snippetTitle = this.config.placeholderText.title;
  }
  if (data.snippetCite == '') {
    data.snippetCite = this.config.placeholderText.url;
  }

  YoastSEO.app.rawData = data;
};

/**
 * when the snippet is updated, set this data in rawData.
 * @param {string} value
 * @param {string} type
 */
YoastSEO_DrupalSource.prototype.setRawData = function( value, type ) {
  switch ( type ) {
    case 'snippet_meta':
      this.parseSnippetData(type, this.config.fields.meta);
      YoastSEO.app.rawData.snippetMeta = value;
      break;
    case 'snippet_cite':
      YoastSEO.app.rawData.snippetCite = value;
      break;
    case 'snippet_title':
      YoastSEO.app.rawData.snippetTitle = value;
      break;
    default:
      break;
  }
};

/**
 * Calls the eventbinders.
 */
YoastSEO_DrupalSource.prototype.bindElementEvents = function() {
  this.inputElementEventBinder();
};

/**
 * Binds the renewData function on the change of inputelements.
 */
YoastSEO_DrupalSource.prototype.inputElementEventBinder = function() {
  for (field in this.config.fields) {
    if (typeof this.config.fields[field] != 'undefined') {
      document.getElementById(this.config.fields[field]).__refObj = this;
      document.getElementById(this.config.fields[field]).addEventListener("input", this.renewData.bind(this));
    }
  }
};

/**
 * calls getAnalyzerinput function on change event from element
 * @param event
 */
YoastSEO_DrupalSource.prototype.renewData = function ( ev ) {
  if (!this.config.SEOTitleOverwritten && (ev.target.id == this.config.fields.title || ev.target.id == this.config.snippetFields.title)) {
    this.config.SEOTitleOverwritten = true;
  }

  YoastSEO.app.analyzeTimer(ev);
};

/**
 * Updates the snippet values, but in reality we ignore this.
 *
 * @param {Object} ev
 */
YoastSEO_DrupalSource.prototype.updateSnippetValues = function( ev ) {
};

/**
 * calles getAnalyzerinput function on focus of the snippet elements;
 * @param event
 */
YoastSEO_DrupalSource.prototype.snippetCallback = function( ev ) {
  this.getAnalyzerInput();
};

/**
 * retuns a string that is used as a CSSclass, based on the numeric score
 * @param score
 * @returns output
 */
YoastSEO_DrupalSource.prototype.scoreRating = function( score ) {
  var scoreRate;
  switch ( score ) {
    case 0:
      scoreRate = "na";
      break;
    case 4:
    case 5:
      scoreRate = "poor";
      break;
    case 6:
    case 7:
      scoreRate = "ok";
      break;
    case 8:
    case 9:
    case 10:
      scoreRate = "good";
      break;
    default:
      scoreRate = "bad";
      break;
  }

  var output = Drupal.t("SEO: <strong>" + scoreRate + "</strong>");

  return output;
};

/**
 * Sets the SEO score in the hidden element.
 * @param score
 */
YoastSEO_DrupalSource.prototype.saveScores = function ( score ) {
  document.getElementById(this.config.targets.overall).getElementsByClassName("score_title")[0].innerHTML = this.scoreRating( score );
  document.getElementById(this.config.scoreElement).value = score;
};
;
(function ($) {

Drupal.behaviors.textarea = {
  attach: function (context, settings) {
    $('.form-textarea-wrapper.resizable', context).once('textarea', function () {
      var staticOffset = null;
      var textarea = $(this).addClass('resizable-textarea').find('textarea');
      var grippie = $('<div class="grippie"></div>').mousedown(startDrag);

      grippie.insertAfter(textarea);

      function startDrag(e) {
        staticOffset = textarea.height() - e.pageY;
        textarea.css('opacity', 0.25);
        $(document).mousemove(performDrag).mouseup(endDrag);
        return false;
      }

      function performDrag(e) {
        textarea.height(Math.max(32, staticOffset + e.pageY) + 'px');
        return false;
      }

      function endDrag(e) {
        $(document).unbind('mousemove', performDrag).unbind('mouseup', endDrag);
        textarea.css('opacity', 1);
      }
    });
  }
};

})(jQuery);
;

(function ($) {

/**
 * Auto-hide summary textarea if empty and show hide and unhide links.
 */
Drupal.behaviors.textSummary = {
  attach: function (context, settings) {
    $('.text-summary', context).once('text-summary', function () {
      var $widget = $(this).closest('div.field-type-text-with-summary');
      var $summaries = $widget.find('div.text-summary-wrapper');

      $summaries.once('text-summary-wrapper').each(function(index) {
        var $summary = $(this);
        var $summaryLabel = $summary.find('label').first();
        var $full = $widget.find('.text-full').eq(index).closest('.form-item');
        var $fullLabel = $full.find('label').first();

        // Create a placeholder label when the field cardinality is
        // unlimited or greater than 1.
        if ($fullLabel.length == 0) {
          $fullLabel = $('<label></label>').prependTo($full);
        }

        // Setup the edit/hide summary link.
        var $link = $('<span class="field-edit-link">(<a class="link-edit-summary" href="#">' + Drupal.t('Hide summary') + '</a>)</span>');
        var $a = $link.find('a');
        var toggleClick = true;
        $link.bind('click', function (e) {
          if (toggleClick) {
            $summary.hide();
            $a.html(Drupal.t('Edit summary'));
            $link.appendTo($fullLabel);
          }
          else {
            $summary.show();
            $a.html(Drupal.t('Hide summary'));
            $link.appendTo($summaryLabel);
          }
          toggleClick = !toggleClick;
          return false;
        }).appendTo($summaryLabel);

        // If no summary is set, hide the summary field.
        if ($(this).find('.text-summary').val() == '') {
          $link.click();
        }
      });
    });
  }
};

})(jQuery);
;

/**
 * @file: Popup dialog interfaces for the media project.
 *
 * Drupal.media.popups.mediaBrowser
 *   Launches the media browser which allows users to pick a piece of media.
 *
 * Drupal.media.popups.mediaStyleSelector
 *  Launches the style selection form where the user can choose
 *  what format / style they want their media in.
 *
 */

(function ($) {
namespace('Drupal.media.popups');

/**
 * Media browser popup. Creates a media browser dialog.
 *
 * @param {function}
 *          onSelect Callback for when dialog is closed, received (Array
 *          media, Object extra);
 * @param {Object}
 *          globalOptions Global options that will get passed upon initialization of the browser.
 *          @see Drupal.media.popups.mediaBrowser.getDefaults();
 *
 * @param {Object}
 *          pluginOptions Options for specific plugins. These are passed
 *          to the plugin upon initialization.  If a function is passed here as
 *          a callback, it is obviously not passed, but is accessible to the plugin
 *          in Drupal.settings.variables.
 *
 *          Example
 *          pluginOptions = {library: {url_include_patterns:'/foo/bar'}};
 *
 * @param {Object}
 *          widgetOptions Options controlling the appearance and behavior of the
 *          modal dialog.
 *          @see Drupal.media.popups.mediaBrowser.getDefaults();
 */
Drupal.media.popups.mediaBrowser = function (onSelect, globalOptions, pluginOptions, widgetOptions) {
  exits_dialog=document.querySelector(".media-wrapper");
  if (exits_dialog!=null) {return false;}
  var options = Drupal.media.popups.mediaBrowser.getDefaults();
  options.global = $.extend({}, options.global, globalOptions);
  options.plugins = pluginOptions;
  options.widget = $.extend({}, options.widget, widgetOptions);

  // Create it as a modal window.
  var browserSrc = options.widget.src;
  if ($.isArray(browserSrc) && browserSrc.length) {
    browserSrc = browserSrc[browserSrc.length - 1];
  }
  // Params to send along to the iframe.  WIP.
  var params = {};
  $.extend(params, options.global);
  params.plugins = options.plugins;

  browserSrc += '&' + $.param(params);
  var mediaIframe = Drupal.media.popups.getPopupIframe(browserSrc, 'mediaBrowser');
  // Attach the onLoad event
  mediaIframe.bind('load', options, options.widget.onLoad);

  /**
   * Setting up the modal dialog
   */
  var ok = 'OK';
  var notSelected = 'You have not selected anything!';

  if (Drupal && Drupal.t) {
    ok = Drupal.t(ok);
    notSelected = Drupal.t(notSelected);
  }

  // @todo: let some options come through here. Currently can't be changed.
  var dialogOptions = options.dialog;

  dialogOptions.buttons[ok] = function () {
    var selected = this.contentWindow.Drupal.media.browser.selectedMedia;
    if (selected.length < 1) {
      alert(notSelected);
      return;
    }
    onSelect(selected);
    $(this).dialog("close");
  };

  var dialog = mediaIframe.dialog(dialogOptions);

  Drupal.media.popups.sizeDialog(dialog);
  Drupal.media.popups.resizeDialog(dialog);
  Drupal.media.popups.scrollDialog(dialog);
  Drupal.media.popups.overlayDisplace(dialog.parents(".ui-dialog"));

  return mediaIframe;
};

Drupal.media.popups.mediaBrowser.mediaBrowserOnLoad = function (e) {
  var options = e.data;
  if (this.contentWindow.Drupal.media == undefined) return;

  if (this.contentWindow.Drupal.media.browser.selectedMedia.length > 0) {
    var ok = (Drupal && Drupal.t) ? Drupal.t('OK') : 'OK';
    var ok_func = $(this).dialog('option', 'buttons')[ok];
    ok_func.call(this);
    return;
  }
};

Drupal.media.popups.mediaBrowser.getDefaults = function () {
  return {
    global: {
      types: [], // Types to allow, defaults to all.
      activePlugins: [] // If provided, a list of plugins which should be enabled.
    },
    widget: { // Settings for the actual iFrame which is launched.
      src: Drupal.settings.media.browserUrl, // Src of the media browser (if you want to totally override it)
      onLoad: Drupal.media.popups.mediaBrowser.mediaBrowserOnLoad // Onload function when iFrame loads.
    },
    dialog: Drupal.media.popups.getDialogOptions()
  };
};

Drupal.media.popups.mediaBrowser.finalizeSelection = function () {
  var selected = this.contentWindow.Drupal.media.browser.selectedMedia;
  if (selected.length < 1) {
    alert(notSelected);
    return;
  }
  onSelect(selected);
  $(this).dialog("close");
}

/**
 * Style chooser Popup. Creates a dialog for a user to choose a media style.
 *
 * @param mediaFile
 *          The mediaFile you are requesting this formatting form for.
 *          @todo: should this be fid?  That's actually all we need now.
 *
 * @param Function
 *          onSubmit Function to be called when the user chooses a media
 *          style. Takes one parameter (Object formattedMedia).
 *
 * @param Object
 *          options Options for the mediaStyleChooser dialog.
 */
Drupal.media.popups.mediaStyleSelector = function (mediaFile, onSelect, options) {
  var defaults = Drupal.media.popups.mediaStyleSelector.getDefaults();
  // @todo: remove this awful hack :(
  if (typeof defaults.src === 'string' ) {
    defaults.src = defaults.src.replace('-media_id-', mediaFile.fid) + '&fields=' + encodeURIComponent(JSON.stringify(mediaFile.fields));
  }
  else {
    var src = defaults.src.shift();
    defaults.src.unshift(src);
    defaults.src = src.replace('-media_id-', mediaFile.fid) + '&fields=' + encodeURIComponent(JSON.stringify(mediaFile.fields));
  }
  options = $.extend({}, defaults, options);
  // Create it as a modal window.
  var mediaIframe = Drupal.media.popups.getPopupIframe(options.src, 'mediaStyleSelector');
  // Attach the onLoad event
  mediaIframe.bind('load', options, options.onLoad);

  /**
   * Set up the button text
   */
  var ok = 'OK';
  var notSelected = 'Very sorry, there was an unknown error embedding media.';

  if (Drupal && Drupal.t) {
    ok = Drupal.t(ok);
    notSelected = Drupal.t(notSelected);
  }

  // @todo: let some options come through here. Currently can't be changed.
  var dialogOptions = Drupal.media.popups.getDialogOptions();

  dialogOptions.buttons[ok] = function () {

    var formattedMedia = this.contentWindow.Drupal.media.formatForm.getFormattedMedia();
    if (!formattedMedia) {
      alert(notSelected);
      return;
    }
    onSelect(formattedMedia);
    $(this).dialog("close");
  };

  var dialog = mediaIframe.dialog(dialogOptions);

  Drupal.media.popups.sizeDialog(dialog);
  Drupal.media.popups.resizeDialog(dialog);
  Drupal.media.popups.scrollDialog(dialog);
  Drupal.media.popups.overlayDisplace(dialog.parents(".ui-dialog"));

  return mediaIframe;
};

Drupal.media.popups.mediaStyleSelector.mediaBrowserOnLoad = function (e) {
};

Drupal.media.popups.mediaStyleSelector.getDefaults = function () {
  return {
    src: Drupal.settings.media.styleSelectorUrl,
    onLoad: Drupal.media.popups.mediaStyleSelector.mediaBrowserOnLoad
  };
};


/**
 * Style chooser Popup. Creates a dialog for a user to choose a media style.
 *
 * @param mediaFile
 *          The mediaFile you are requesting this formatting form for.
 *          @todo: should this be fid?  That's actually all we need now.
 *
 * @param Function
 *          onSubmit Function to be called when the user chooses a media
 *          style. Takes one parameter (Object formattedMedia).
 *
 * @param Object
 *          options Options for the mediaStyleChooser dialog.
 */
Drupal.media.popups.mediaFieldEditor = function (fid, onSelect, options) {
  var defaults = Drupal.media.popups.mediaFieldEditor.getDefaults();
  // @todo: remove this awful hack :(
  defaults.src = defaults.src.replace('-media_id-', fid);
  options = $.extend({}, defaults, options);
  // Create it as a modal window.
  var mediaIframe = Drupal.media.popups.getPopupIframe(options.src, 'mediaFieldEditor');
  // Attach the onLoad event
  // @TODO - This event is firing too early in IE on Windows 7,
  // - so the height being calculated is too short for the content.
  mediaIframe.bind('load', options, options.onLoad);

  /**
   * Set up the button text
   */
  var ok = 'OK';
  var notSelected = 'Very sorry, there was an unknown error embedding media.';

  if (Drupal && Drupal.t) {
    ok = Drupal.t(ok);
    notSelected = Drupal.t(notSelected);
  }

  // @todo: let some options come through here. Currently can't be changed.
  var dialogOptions = Drupal.media.popups.getDialogOptions();

  dialogOptions.buttons[ok] = function () {
    var formattedMedia = this.contentWindow.Drupal.media.formatForm.getFormattedMedia();
    if (!formattedMedia) {
      alert(notSelected);
      return;
    }
    onSelect(formattedMedia);
    $(this).dialog("close");
  };

  var dialog = mediaIframe.dialog(dialogOptions);

  Drupal.media.popups.sizeDialog(dialog);
  Drupal.media.popups.resizeDialog(dialog);
  Drupal.media.popups.scrollDialog(dialog);
  Drupal.media.popups.overlayDisplace(dialog);

  return mediaIframe;
};

Drupal.media.popups.mediaFieldEditor.mediaBrowserOnLoad = function (e) {

};

Drupal.media.popups.mediaFieldEditor.getDefaults = function () {
  return {
    // @todo: do this for real
    src: '/media/-media_id-/edit?render=media-popup',
    onLoad: Drupal.media.popups.mediaFieldEditor.mediaBrowserOnLoad
  };
};


/**
 * Generic functions to both the media-browser and style selector
 */

/**
 * Returns the commonly used options for the dialog.
 */
Drupal.media.popups.getDialogOptions = function () {
  return {
    buttons: {},
    dialogClass: Drupal.settings.media.dialogOptions.dialogclass,
    modal: Drupal.settings.media.dialogOptions.modal,
    draggable: Drupal.settings.media.dialogOptions.draggable,
    resizable: Drupal.settings.media.dialogOptions.resizable,
    minWidth: Drupal.settings.media.dialogOptions.minwidth,
    width: Drupal.settings.media.dialogOptions.width,
    height: Drupal.settings.media.dialogOptions.height,
    position: Drupal.settings.media.dialogOptions.position,
    overlay: {
      backgroundColor: Drupal.settings.media.dialogOptions.overlay.backgroundcolor,
      opacity: Drupal.settings.media.dialogOptions.overlay.opacity
    },
    zIndex: Drupal.settings.media.dialogOptions.zindex,
    close: function (event, ui) {
      $(event.target).remove();
    }
  };
};

/**
 * Get an iframe to serve as the dialog's contents. Common to both plugins.
 */
Drupal.media.popups.getPopupIframe = function (src, id, options) {
  var defaults = {width: '100%', scrolling: 'auto'};
  var options = $.extend({}, defaults, options);

  return $('<iframe class="media-modal-frame"/>')
  .attr('src', src)
  .attr('width', options.width)
  .attr('id', id)
  .attr('scrolling', options.scrolling);
};

Drupal.media.popups.overlayDisplace = function (dialog) {
  if (parent.window.Drupal.overlay && jQuery.isFunction(parent.window.Drupal.overlay.getDisplacement)) {
    var overlayDisplace = parent.window.Drupal.overlay.getDisplacement('top');
    if (dialog.offset().top < overlayDisplace) {
      dialog.css('top', overlayDisplace);
    }
  }
}

/**
 * Size the dialog when it is first loaded and keep it centered when scrolling.
 *
 * @param jQuery dialogElement
 *  The element which has .dialog() attached to it.
 */
Drupal.media.popups.sizeDialog = function (dialogElement) {
  if (!dialogElement.is(':visible')) {
    return;
  }
  var windowWidth = $(window).width();
  var dialogWidth = windowWidth * 0.8;
  var windowHeight = $(window).height();
  var dialogHeight = windowHeight * 0.8;

  dialogElement.dialog("option", "width", dialogWidth);
  dialogElement.dialog("option", "height", dialogHeight);
  dialogElement.dialog("option", "position", 'center');

  $('.media-modal-frame').width('100%');
}

/**
 * Resize the dialog when the window changes.
 *
 * @param jQuery dialogElement
 *  The element which has .dialog() attached to it.
 */
Drupal.media.popups.resizeDialog = function (dialogElement) {
  $(window).resize(function() {
    Drupal.media.popups.sizeDialog(dialogElement);
  });
}

/**
 * Keeps the dialog centered when the window is scrolled.
 *
 * @param jQuery dialogElement
 *  The element which has .dialog() attached to it.
 */
Drupal.media.popups.scrollDialog = function (dialogElement) {
  // Keep the dialog window centered when scrolling.
  $(window).scroll(function() {
    if (!dialogElement.is(':visible')) {
      return;
    }
    dialogElement.dialog("option", "position", 'center');
  });
}

})(jQuery);
;
(function ($) {

/**
 * Automatically display the guidelines of the selected text format.
 */
Drupal.behaviors.filterGuidelines = {
  attach: function (context) {
    $('.filter-guidelines', context).once('filter-guidelines')
      .find(':header').hide()
      .closest('.filter-wrapper').find('select.filter-list')
      .bind('change', function () {
        $(this).closest('.filter-wrapper')
          .find('.filter-guidelines-item').hide()
          .siblings('.filter-guidelines-' + this.value).show();
      })
      .change();
  }
};

})(jQuery);
;
/**
 *  @file
 *  File with utilities to handle media in html editing.
 */
(function ($) {

  Drupal.media = Drupal.media || {};
  /**
   * Utility to deal with media tokens / placeholders.
   */
  Drupal.media.filter = {
    /**
     * Replaces media tokens with the placeholders for html editing.
     * @param content
     */
    replaceTokenWithPlaceholder: function(content) {
      Drupal.media.filter.ensure_tagmap();
      var matches = content.match(/\[\[.*?\]\]/g);

      if (matches) {
        for (var i = 0; i < matches.length; i++) {
          var match = matches[i];
          if (match.indexOf('"type":"media"') == -1) {
            continue;
          }

          // Check if the macro exists in the tagmap. This ensures backwards
          // compatibility with existing media and is moderately more efficient
          // than re-building the element.
          var media = Drupal.settings.tagmap[match];
          var media_json = match.replace('[[', '').replace(']]', '');

          // Ensure that the media JSON is valid.
          try {
            var media_definition = JSON.parse(media_json);
          }
          catch (err) {
            // @todo: error logging.
            // Content should be returned to prevent an empty editor.
            return content;
          }

          // Re-build the media if the macro has changed from the tagmap.
          if (!media && media_definition.fid) {
            Drupal.media.filter.ensureSourceMap();
            var source = Drupal.settings.mediaSourceMap[media_definition.fid];
            media = document.createElement(source.tagName);
            media.src = source.src;
            media.innerHTML = source.innerHTML;
          }

          // Apply attributes.
          var element = Drupal.media.filter.create_element(media, media_definition);
          var markup  = Drupal.media.filter.outerHTML(element);

          // Use split and join to replace all instances of macro with markup.
          content = content.split(match).join(markup);
        }
      }

      return content;
    },

    /**
     * Replaces media elements with tokens.
     *
     * @param content (string)
     *   The markup within the wysiwyg instance.
     */
    replacePlaceholderWithToken: function(content) {
      Drupal.media.filter.ensure_tagmap();

      // Rewrite the tagmap in case any of the macros have changed.
      Drupal.settings.tagmap = {};

      // Replace all media placeholders with their JSON macro representations.
      //
      // There are issues with using jQuery to parse the WYSIWYG content (see
      // http://drupal.org/node/1280758), and parsing HTML with regular
      // expressions is a terrible idea (see http://stackoverflow.com/a/1732454/854985)
      //
      // WYSIWYG editors act wacky with complex placeholder markup anyway, so an
      // image is the most reliable and most usable anyway: images can be moved by
      // dragging and dropping, and can be resized using interactive handles.
      //
      // Media requests a WYSIWYG place holder rendering of the file by passing
      // the wysiwyg => 1 flag in the settings array when calling
      // media_get_file_without_label().
      //
      // Finds the media-element class.
      var classRegex = 'class=[\'"][^\'"]*?media-element';
      // Image tag with the media-element class.
      var regex = '<img[^>]+' + classRegex + '[^>]*?>';
      // Or a span with the media-element class (used for documents).
      // \S\s catches any character, including a linebreak; JavaScript does not
      // have a dotall flag.
      regex += '|<span[^>]+' + classRegex + '[^>]*?>[\\S\\s]+?</span>';
      var matches = content.match(RegExp(regex, 'gi'));
      if (matches) {
        for (i = 0; i < matches.length; i++) {
          markup = matches[i];
          macro = Drupal.media.filter.create_macro($(markup));
          Drupal.settings.tagmap[macro] = markup;
          content = content.replace(markup, macro);
        }
      }

      return content;
    },

    /**
     * Serializes file information as a url-encoded JSON object and stores it
     * as a data attribute on the html element.
     *
     * @param html (string)
     *    A html element to be used to represent the inserted media element.
     * @param info (object)
     *    A object containing the media file information (fid, view_mode, etc).
     */
    create_element: function (html, info) {
      if ($('<div>').append(html).text().length === html.length) {
        // Element is not an html tag. Surround it in a span element so we can
        // pass the file attributes.
        html = '<span>' + html + '</span>';
      }
      var element = $(html);

      // Parse out link wrappers. They will be re-applied when the image is
      // rendered on the front-end.
      if (element.is('a')) {
        element = element.children();
      }

      // Move attributes from the file info array to the placeholder element.
      if (info.attributes) {
        $.each(Drupal.settings.media.wysiwyg_allowed_attributes, function(i, a) {
          if (info.attributes[a]) {
            element.attr(a, info.attributes[a]);
          }
        });
        delete(info.attributes);

        // Store information to rebuild the element later, if necessary.
        Drupal.media.filter.ensureSourceMap();
        Drupal.settings.mediaSourceMap[info.fid] = {
          tagName: element[0].tagName,
          src: element[0].src,
          innerHTML: element[0].innerHTML
        }
      }

      info.type = info.type || "media";

      // Store the data in the data map.
      Drupal.media.filter.ensureDataMap();
      Drupal.settings.mediaDataMap[info.fid] = info;

      // Store the fid in the DOM to retrieve the data from the info map.
      element.attr('data-fid', info.fid);

      // Add data-media-element attribute so we can find the markup element later.
      element.attr('data-media-element', '1')

      var classes = ['media-element'];
      if (info.view_mode) {
        classes.push('file-' + info.view_mode.replace(/_/g, '-'));
      }
      element.addClass(classes.join(' '));

      // Apply link_text if present.
      if (info.link_text) {
        $('a', element).html(info.link_text);
      }

      return element;
    },

    /**
     * Create a macro representation of the inserted media element.
     *
     * @param element (jQuery object)
     *    A media element with attached serialized file info.
     */
    create_macro: function (element) {
      var file_info = Drupal.media.filter.extract_file_info(element);
      if (file_info) {
        if (typeof file_info.link_text == 'string') {
          // Make sure the link_text-html-tags are properly escaped.
          file_info.link_text = file_info.link_text.replace(/</g, '&lt;').replace(/>/g, '&gt;');
        }
        return '[[' + JSON.stringify(file_info) + ']]';
      }
      return false;
    },

    /**
     * Extract the file info from a WYSIWYG placeholder element as JSON.
     *
     * @param element (jQuery object)
     *    A media element with associated file info via a file id (fid).
     */
    extract_file_info: function (element) {
      var fid, file_info, value;

      if (fid = element.data('fid')) {
        Drupal.media.filter.ensureDataMap();

        if (file_info = Drupal.settings.mediaDataMap[fid]) {
          file_info.attributes = {};

          $.each(Drupal.settings.media.wysiwyg_allowed_attributes, function(i, a) {
            if (value = element.attr(a)) {
              // Replace &quot; by \" to avoid error with JSON format.
              if (typeof value == 'string') {
                value = value.replace('&quot;', '\\"');
              }
              file_info.attributes[a] = value;
            }
          });

          // Extract the link text, if there is any.
          file_info.link_text = element.find('a').html();
        }
      }

      return file_info;
    },

    /**
     * Gets the HTML content of an element.
     *
     * @param element (jQuery object)
     */
    outerHTML: function (element) {
      return element[0].outerHTML || $('<div>').append(element.eq(0).clone()).html();
    },

    /**
     * Gets the wrapped HTML content of an element to insert into the wysiwyg.
     *
     * It also registers the element in the tag map so that the token
     * replacement works.
     *
     * @param element (jQuery object) The element to insert.
     *
     * @see Drupal.media.filter.replacePlaceholderWithToken()
     */
    getWysiwygHTML: function (element) {
      // Create the markup and the macro.
      var markup = Drupal.media.filter.outerHTML(element),
        macro = Drupal.media.filter.create_macro(element);

      // Store macro/markup in the tagmap.
      Drupal.media.filter.ensure_tagmap();
      Drupal.settings.tagmap[macro] = markup;

      // Return the html code to insert in an editor and use it with
      // replacePlaceholderWithToken()
      return markup;
    },

    /**
     * Ensures the src tracking has been initialized and returns it.
     */
    ensureSourceMap: function() {
      Drupal.settings.mediaSourceMap = Drupal.settings.mediaSourceMap || {};
      return Drupal.settings.mediaSourceMap;
    },

    /**
     * Ensures the data tracking has been initialized and returns it.
     */
    ensureDataMap: function() {
      Drupal.settings.mediaDataMap = Drupal.settings.mediaDataMap || {};
      return Drupal.settings.mediaDataMap;
    },

    /**
     * Ensures the tag map has been initialized and returns it.
     */
    ensure_tagmap: function () {
      Drupal.settings.tagmap = Drupal.settings.tagmap || {};
      return Drupal.settings.tagmap;
    }
  }

})(jQuery);
;
(function ($) {

/**
 * Attaches the autocomplete behavior to all required fields.
 */
Drupal.behaviors.autocomplete = {
  attach: function (context, settings) {
    var acdb = [];
    $('input.autocomplete', context).once('autocomplete', function () {
      var uri = this.value;
      if (!acdb[uri]) {
        acdb[uri] = new Drupal.ACDB(uri);
      }
      var $input = $('#' + this.id.substr(0, this.id.length - 13))
        .attr('autocomplete', 'OFF')
        .attr('aria-autocomplete', 'list');
      $($input[0].form).submit(Drupal.autocompleteSubmit);
      $input.parent()
        .attr('role', 'application')
        .append($('<span class="element-invisible" aria-live="assertive"></span>')
          .attr('id', $input.attr('id') + '-autocomplete-aria-live')
        );
      new Drupal.jsAC($input, acdb[uri]);
    });
  }
};

/**
 * Prevents the form from submitting if the suggestions popup is open
 * and closes the suggestions popup when doing so.
 */
Drupal.autocompleteSubmit = function () {
  return $('#autocomplete').each(function () {
    this.owner.hidePopup();
  }).length == 0;
};

/**
 * An AutoComplete object.
 */
Drupal.jsAC = function ($input, db) {
  var ac = this;
  this.input = $input[0];
  this.ariaLive = $('#' + this.input.id + '-autocomplete-aria-live');
  this.db = db;

  $input
    .keydown(function (event) { return ac.onkeydown(this, event); })
    .keyup(function (event) { ac.onkeyup(this, event); })
    .blur(function () { ac.hidePopup(); ac.db.cancel(); });

};

/**
 * Handler for the "keydown" event.
 */
Drupal.jsAC.prototype.onkeydown = function (input, e) {
  if (!e) {
    e = window.event;
  }
  switch (e.keyCode) {
    case 40: // down arrow.
      this.selectDown();
      return false;
    case 38: // up arrow.
      this.selectUp();
      return false;
    default: // All other keys.
      return true;
  }
};

/**
 * Handler for the "keyup" event.
 */
Drupal.jsAC.prototype.onkeyup = function (input, e) {
  if (!e) {
    e = window.event;
  }
  switch (e.keyCode) {
    case 16: // Shift.
    case 17: // Ctrl.
    case 18: // Alt.
    case 20: // Caps lock.
    case 33: // Page up.
    case 34: // Page down.
    case 35: // End.
    case 36: // Home.
    case 37: // Left arrow.
    case 38: // Up arrow.
    case 39: // Right arrow.
    case 40: // Down arrow.
      return true;

    case 9:  // Tab.
    case 13: // Enter.
    case 27: // Esc.
      this.hidePopup(e.keyCode);
      return true;

    default: // All other keys.
      if (input.value.length > 0 && !input.readOnly) {
        this.populatePopup();
      }
      else {
        this.hidePopup(e.keyCode);
      }
      return true;
  }
};

/**
 * Puts the currently highlighted suggestion into the autocomplete field.
 */
Drupal.jsAC.prototype.select = function (node) {
  this.input.value = $(node).data('autocompleteValue');
  $(this.input).trigger('autocompleteSelect', [node]);
};

/**
 * Highlights the next suggestion.
 */
Drupal.jsAC.prototype.selectDown = function () {
  if (this.selected && this.selected.nextSibling) {
    this.highlight(this.selected.nextSibling);
  }
  else if (this.popup) {
    var lis = $('li', this.popup);
    if (lis.length > 0) {
      this.highlight(lis.get(0));
    }
  }
};

/**
 * Highlights the previous suggestion.
 */
Drupal.jsAC.prototype.selectUp = function () {
  if (this.selected && this.selected.previousSibling) {
    this.highlight(this.selected.previousSibling);
  }
};

/**
 * Highlights a suggestion.
 */
Drupal.jsAC.prototype.highlight = function (node) {
  if (this.selected) {
    $(this.selected).removeClass('selected');
  }
  $(node).addClass('selected');
  this.selected = node;
  $(this.ariaLive).html($(this.selected).html());
};

/**
 * Unhighlights a suggestion.
 */
Drupal.jsAC.prototype.unhighlight = function (node) {
  $(node).removeClass('selected');
  this.selected = false;
  $(this.ariaLive).empty();
};

/**
 * Hides the autocomplete suggestions.
 */
Drupal.jsAC.prototype.hidePopup = function (keycode) {
  // Select item if the right key or mousebutton was pressed.
  if (this.selected && ((keycode && keycode != 46 && keycode != 8 && keycode != 27) || !keycode)) {
    this.select(this.selected);
  }
  // Hide popup.
  var popup = this.popup;
  if (popup) {
    this.popup = null;
    $(popup).fadeOut('fast', function () { $(popup).remove(); });
  }
  this.selected = false;
  $(this.ariaLive).empty();
};

/**
 * Positions the suggestions popup and starts a search.
 */
Drupal.jsAC.prototype.populatePopup = function () {
  var $input = $(this.input);
  var position = $input.position();
  // Show popup.
  if (this.popup) {
    $(this.popup).remove();
  }
  this.selected = false;
  this.popup = $('<div id="autocomplete"></div>')[0];
  this.popup.owner = this;
  $(this.popup).css({
    top: parseInt(position.top + this.input.offsetHeight, 10) + 'px',
    left: parseInt(position.left, 10) + 'px',
    width: $input.innerWidth() + 'px',
    display: 'none'
  });
  $input.before(this.popup);

  // Do search.
  this.db.owner = this;
  this.db.search(this.input.value);
};

/**
 * Fills the suggestion popup with any matches received.
 */
Drupal.jsAC.prototype.found = function (matches) {
  // If no value in the textfield, do not show the popup.
  if (!this.input.value.length) {
    return false;
  }

  // Prepare matches.
  var ul = $('<ul></ul>');
  var ac = this;
  for (key in matches) {
    $('<li></li>')
      .html($('<div></div>').html(matches[key]))
      .mousedown(function () { ac.hidePopup(this); })
      .mouseover(function () { ac.highlight(this); })
      .mouseout(function () { ac.unhighlight(this); })
      .data('autocompleteValue', key)
      .appendTo(ul);
  }

  // Show popup with matches, if any.
  if (this.popup) {
    if (ul.children().length) {
      $(this.popup).empty().append(ul).show();
      $(this.ariaLive).html(Drupal.t('Autocomplete popup'));
    }
    else {
      $(this.popup).css({ visibility: 'hidden' });
      this.hidePopup();
    }
  }
};

Drupal.jsAC.prototype.setStatus = function (status) {
  switch (status) {
    case 'begin':
      $(this.input).addClass('throbbing');
      $(this.ariaLive).html(Drupal.t('Searching for matches...'));
      break;
    case 'cancel':
    case 'error':
    case 'found':
      $(this.input).removeClass('throbbing');
      break;
  }
};

/**
 * An AutoComplete DataBase object.
 */
Drupal.ACDB = function (uri) {
  this.uri = uri;
  this.delay = 300;
  this.cache = {};
};

/**
 * Performs a cached and delayed search.
 */
Drupal.ACDB.prototype.search = function (searchString) {
  var db = this;
  this.searchString = searchString;

  // See if this string needs to be searched for anyway. The pattern ../ is
  // stripped since it may be misinterpreted by the browser.
  searchString = searchString.replace(/^\s+|\.{2,}\/|\s+$/g, '');
  // Skip empty search strings, or search strings ending with a comma, since
  // that is the separator between search terms.
  if (searchString.length <= 0 ||
    searchString.charAt(searchString.length - 1) == ',') {
    return;
  }

  // See if this key has been searched for before.
  if (this.cache[searchString]) {
    return this.owner.found(this.cache[searchString]);
  }

  // Initiate delayed search.
  if (this.timer) {
    clearTimeout(this.timer);
  }
  this.timer = setTimeout(function () {
    db.owner.setStatus('begin');

    // Ajax GET request for autocompletion. We use Drupal.encodePath instead of
    // encodeURIComponent to allow autocomplete search terms to contain slashes.
    $.ajax({
      type: 'GET',
      url: db.uri + '/' + Drupal.encodePath(searchString),
      dataType: 'json',
      success: function (matches) {
        if (typeof matches.status == 'undefined' || matches.status != 0) {
          db.cache[searchString] = matches;
          // Verify if these are still the matches the user wants to see.
          if (db.searchString == searchString) {
            db.owner.found(matches);
          }
          db.owner.setStatus('found');
        }
      },
      error: function (xmlhttp) {
        alert(Drupal.ajaxError(xmlhttp, db.uri));
      }
    });
  }, this.delay);
};

/**
 * Cancels the current autocomplete request.
 */
Drupal.ACDB.prototype.cancel = function () {
  if (this.owner) this.owner.setStatus('cancel');
  if (this.timer) clearTimeout(this.timer);
  this.searchString = '';
};

})(jQuery);
;
(function ($) {

/**
 * A progressbar object. Initialized with the given id. Must be inserted into
 * the DOM afterwards through progressBar.element.
 *
 * method is the function which will perform the HTTP request to get the
 * progress bar state. Either "GET" or "POST".
 *
 * e.g. pb = new progressBar('myProgressBar');
 *      some_element.appendChild(pb.element);
 */
Drupal.progressBar = function (id, updateCallback, method, errorCallback) {
  var pb = this;
  this.id = id;
  this.method = method || 'GET';
  this.updateCallback = updateCallback;
  this.errorCallback = errorCallback;

  // The WAI-ARIA setting aria-live="polite" will announce changes after users
  // have completed their current activity and not interrupt the screen reader.
  this.element = $('<div class="progress" aria-live="polite"></div>').attr('id', id);
  this.element.html('<div class="bar"><div class="filled"></div></div>' +
                    '<div class="percentage"></div>' +
                    '<div class="message">&nbsp;</div>');
};

/**
 * Set the percentage and status message for the progressbar.
 */
Drupal.progressBar.prototype.setProgress = function (percentage, message) {
  if (percentage >= 0 && percentage <= 100) {
    $('div.filled', this.element).css('width', percentage + '%');
    $('div.percentage', this.element).html(percentage + '%');
  }
  $('div.message', this.element).html(message);
  if (this.updateCallback) {
    this.updateCallback(percentage, message, this);
  }
};

/**
 * Start monitoring progress via Ajax.
 */
Drupal.progressBar.prototype.startMonitoring = function (uri, delay) {
  this.delay = delay;
  this.uri = uri;
  this.sendPing();
};

/**
 * Stop monitoring progress via Ajax.
 */
Drupal.progressBar.prototype.stopMonitoring = function () {
  clearTimeout(this.timer);
  // This allows monitoring to be stopped from within the callback.
  this.uri = null;
};

/**
 * Request progress data from server.
 */
Drupal.progressBar.prototype.sendPing = function () {
  if (this.timer) {
    clearTimeout(this.timer);
  }
  if (this.uri) {
    var pb = this;
    // When doing a post request, you need non-null data. Otherwise a
    // HTTP 411 or HTTP 406 (with Apache mod_security) error may result.
    $.ajax({
      type: this.method,
      url: this.uri,
      data: '',
      dataType: 'json',
      success: function (progress) {
        // Display errors.
        if (progress.status == 0) {
          pb.displayError(progress.data);
          return;
        }
        // Update display.
        pb.setProgress(progress.percentage, progress.message);
        // Schedule next timer.
        pb.timer = setTimeout(function () { pb.sendPing(); }, pb.delay);
      },
      error: function (xmlhttp) {
        pb.displayError(Drupal.ajaxError(xmlhttp, pb.uri));
      }
    });
  }
};

/**
 * Display errors on the page.
 */
Drupal.progressBar.prototype.displayError = function (string) {
  var error = $('<div class="messages error"></div>').html(string);
  $(this.element).before(error).hide();

  if (this.errorCallback) {
    this.errorCallback(this);
  }
};

})(jQuery);
;
(function ($) {

/**
 * Attaches sticky table headers.
 */
Drupal.behaviors.tableHeader = {
  attach: function (context, settings) {
    if (!$.support.positionFixed) {
      return;
    }

    $('table.sticky-enabled', context).once('tableheader', function () {
      $(this).data("drupal-tableheader", new Drupal.tableHeader(this));
    });
  }
};

/**
 * Constructor for the tableHeader object. Provides sticky table headers.
 *
 * @param table
 *   DOM object for the table to add a sticky header to.
 */
Drupal.tableHeader = function (table) {
  var self = this;

  this.originalTable = $(table);
  this.originalHeader = $(table).children('thead');
  this.originalHeaderCells = this.originalHeader.find('> tr > th');
  this.displayWeight = null;

  // React to columns change to avoid making checks in the scroll callback.
  this.originalTable.bind('columnschange', function (e, display) {
    // This will force header size to be calculated on scroll.
    self.widthCalculated = (self.displayWeight !== null && self.displayWeight === display);
    self.displayWeight = display;
  });

  // Clone the table header so it inherits original jQuery properties. Hide
  // the table to avoid a flash of the header clone upon page load.
  this.stickyTable = $('<table class="sticky-header"/>')
    .insertBefore(this.originalTable)
    .css({ position: 'fixed', top: '0px' });
  this.stickyHeader = this.originalHeader.clone(true)
    .hide()
    .appendTo(this.stickyTable);
  this.stickyHeaderCells = this.stickyHeader.find('> tr > th');

  this.originalTable.addClass('sticky-table');
  $(window)
    .bind('scroll.drupal-tableheader', $.proxy(this, 'eventhandlerRecalculateStickyHeader'))
    .bind('resize.drupal-tableheader', { calculateWidth: true }, $.proxy(this, 'eventhandlerRecalculateStickyHeader'))
    // Make sure the anchor being scrolled into view is not hidden beneath the
    // sticky table header. Adjust the scrollTop if it does.
    .bind('drupalDisplaceAnchor.drupal-tableheader', function () {
      window.scrollBy(0, -self.stickyTable.outerHeight());
    })
    // Make sure the element being focused is not hidden beneath the sticky
    // table header. Adjust the scrollTop if it does.
    .bind('drupalDisplaceFocus.drupal-tableheader', function (event) {
      if (self.stickyVisible && event.clientY < (self.stickyOffsetTop + self.stickyTable.outerHeight()) && event.$target.closest('sticky-header').length === 0) {
        window.scrollBy(0, -self.stickyTable.outerHeight());
      }
    })
    .triggerHandler('resize.drupal-tableheader');

  // We hid the header to avoid it showing up erroneously on page load;
  // we need to unhide it now so that it will show up when expected.
  this.stickyHeader.show();
};

/**
 * Event handler: recalculates position of the sticky table header.
 *
 * @param event
 *   Event being triggered.
 */
Drupal.tableHeader.prototype.eventhandlerRecalculateStickyHeader = function (event) {
  var self = this;
  var calculateWidth = event.data && event.data.calculateWidth;

  // Reset top position of sticky table headers to the current top offset.
  this.stickyOffsetTop = Drupal.settings.tableHeaderOffset ? eval(Drupal.settings.tableHeaderOffset + '()') : 0;
  this.stickyTable.css('top', this.stickyOffsetTop + 'px');

  // Save positioning data.
  var viewHeight = document.documentElement.scrollHeight || document.body.scrollHeight;
  if (calculateWidth || this.viewHeight !== viewHeight) {
    this.viewHeight = viewHeight;
    this.vPosition = this.originalTable.offset().top - 4 - this.stickyOffsetTop;
    this.hPosition = this.originalTable.offset().left;
    this.vLength = this.originalTable[0].clientHeight - 100;
    calculateWidth = true;
  }

  // Track horizontal positioning relative to the viewport and set visibility.
  var hScroll = document.documentElement.scrollLeft || document.body.scrollLeft;
  var vOffset = (document.documentElement.scrollTop || document.body.scrollTop) - this.vPosition;
  this.stickyVisible = vOffset > 0 && vOffset < this.vLength;
  this.stickyTable.css({ left: (-hScroll + this.hPosition) + 'px', visibility: this.stickyVisible ? 'visible' : 'hidden' });

  // Only perform expensive calculations if the sticky header is actually
  // visible or when forced.
  if (this.stickyVisible && (calculateWidth || !this.widthCalculated)) {
    this.widthCalculated = true;
    var $that = null;
    var $stickyCell = null;
    var display = null;
    var cellWidth = null;
    // Resize header and its cell widths.
    // Only apply width to visible table cells. This prevents the header from
    // displaying incorrectly when the sticky header is no longer visible.
    for (var i = 0, il = this.originalHeaderCells.length; i < il; i += 1) {
      $that = $(this.originalHeaderCells[i]);
      $stickyCell = this.stickyHeaderCells.eq($that.index());
      display = $that.css('display');
      if (display !== 'none') {
        cellWidth = $that.css('width');
        // Exception for IE7.
        if (cellWidth === 'auto') {
          cellWidth = $that[0].clientWidth + 'px';
        }
        $stickyCell.css({'width': cellWidth, 'display': display});
      }
      else {
        $stickyCell.css('display', 'none');
      }
    }
    this.stickyTable.css('width', this.originalTable.outerWidth());
  }
};

})(jQuery);
;
/**
 * @file
 * Provides JavaScript additions to the managed file field type.
 *
 * This file provides progress bar support (if available), popup windows for
 * file previews, and disabling of other file fields during Ajax uploads (which
 * prevents separate file fields from accidentally uploading files).
 */

(function ($) {

/**
 * Attach behaviors to managed file element upload fields.
 */
Drupal.behaviors.fileValidateAutoAttach = {
  attach: function (context, settings) {
    if (settings.file && settings.file.elements) {
      $.each(settings.file.elements, function(selector) {
        var extensions = settings.file.elements[selector];
        $(selector, context).bind('change', {extensions: extensions}, Drupal.file.validateExtension);
      });
    }
  },
  detach: function (context, settings) {
    if (settings.file && settings.file.elements) {
      $.each(settings.file.elements, function(selector) {
        $(selector, context).unbind('change', Drupal.file.validateExtension);
      });
    }
  }
};

/**
 * Attach behaviors to the file upload and remove buttons.
 */
Drupal.behaviors.fileButtons = {
  attach: function (context) {
    $('input.form-submit', context).bind('mousedown', Drupal.file.disableFields);
    $('div.form-managed-file input.form-submit', context).bind('mousedown', Drupal.file.progressBar);
  },
  detach: function (context) {
    $('input.form-submit', context).unbind('mousedown', Drupal.file.disableFields);
    $('div.form-managed-file input.form-submit', context).unbind('mousedown', Drupal.file.progressBar);
  }
};

/**
 * Attach behaviors to links within managed file elements.
 */
Drupal.behaviors.filePreviewLinks = {
  attach: function (context) {
    $('div.form-managed-file .file a, .file-widget .file a', context).bind('click',Drupal.file.openInNewWindow);
  },
  detach: function (context){
    $('div.form-managed-file .file a, .file-widget .file a', context).unbind('click', Drupal.file.openInNewWindow);
  }
};

/**
 * File upload utility functions.
 */
Drupal.file = Drupal.file || {
  /**
   * Client-side file input validation of file extensions.
   */
  validateExtension: function (event) {
    // Remove any previous errors.
    $('.file-upload-js-error').remove();

    // Add client side validation for the input[type=file].
    var extensionPattern = event.data.extensions.replace(/,\s*/g, '|');
    if (extensionPattern.length > 1 && this.value.length > 0) {
      var acceptableMatch = new RegExp('\\.(' + extensionPattern + ')$', 'gi');
      if (!acceptableMatch.test(this.value)) {
        var error = Drupal.t("The selected file %filename cannot be uploaded. Only files with the following extensions are allowed: %extensions.", {
          // According to the specifications of HTML5, a file upload control
          // should not reveal the real local path to the file that a user
          // has selected. Some web browsers implement this restriction by
          // replacing the local path with "C:\fakepath\", which can cause
          // confusion by leaving the user thinking perhaps Drupal could not
          // find the file because it messed up the file path. To avoid this
          // confusion, therefore, we strip out the bogus fakepath string.
          '%filename': this.value.replace('C:\\fakepath\\', ''),
          '%extensions': extensionPattern.replace(/\|/g, ', ')
        });
        $(this).closest('div.form-managed-file').prepend('<div class="messages error file-upload-js-error" aria-live="polite">' + error + '</div>');
        this.value = '';
        return false;
      }
    }
  },
  /**
   * Prevent file uploads when using buttons not intended to upload.
   */
  disableFields: function (event){
    var clickedButton = this;

    // Only disable upload fields for Ajax buttons.
    if (!$(clickedButton).hasClass('ajax-processed')) {
      return;
    }

    // Check if we're working with an "Upload" button.
    var $enabledFields = [];
    if ($(this).closest('div.form-managed-file').length > 0) {
      $enabledFields = $(this).closest('div.form-managed-file').find('input.form-file');
    }

    // Temporarily disable upload fields other than the one we're currently
    // working with. Filter out fields that are already disabled so that they
    // do not get enabled when we re-enable these fields at the end of behavior
    // processing. Re-enable in a setTimeout set to a relatively short amount
    // of time (1 second). All the other mousedown handlers (like Drupal's Ajax
    // behaviors) are excuted before any timeout functions are called, so we
    // don't have to worry about the fields being re-enabled too soon.
    // @todo If the previous sentence is true, why not set the timeout to 0?
    var $fieldsToTemporarilyDisable = $('div.form-managed-file input.form-file').not($enabledFields).not(':disabled');
    $fieldsToTemporarilyDisable.attr('disabled', 'disabled');
    setTimeout(function (){
      $fieldsToTemporarilyDisable.attr('disabled', false);
    }, 1000);
  },
  /**
   * Add progress bar support if possible.
   */
  progressBar: function (event) {
    var clickedButton = this;
    var $progressId = $(clickedButton).closest('div.form-managed-file').find('input.file-progress');
    if ($progressId.length) {
      var originalName = $progressId.attr('name');

      // Replace the name with the required identifier.
      $progressId.attr('name', originalName.match(/APC_UPLOAD_PROGRESS|UPLOAD_IDENTIFIER/)[0]);

      // Restore the original name after the upload begins.
      setTimeout(function () {
        $progressId.attr('name', originalName);
      }, 1000);
    }
    // Show the progress bar if the upload takes longer than half a second.
    setTimeout(function () {
      $(clickedButton).closest('div.form-managed-file').find('div.ajax-progress-bar').slideDown();
    }, 500);
  },
  /**
   * Open links to files within forms in a new window.
   */
  openInNewWindow: function (event) {
    $(this).attr('target', '_blank');
    window.open(this.href, 'filePreview', 'toolbar=0,scrollbars=1,location=1,statusbar=1,menubar=0,resizable=1,width=500,height=550');
    return false;
  }
};

})(jQuery);
;
(function ($) {

/**
 * Toggle the visibility of a fieldset using smooth animations.
 */
Drupal.toggleFieldset = function (fieldset) {
  var $fieldset = $(fieldset);
  if ($fieldset.is('.collapsed')) {
    var $content = $('> .fieldset-wrapper', fieldset).hide();
    $fieldset
      .removeClass('collapsed')
      .trigger({ type: 'collapsed', value: false })
      .find('> legend span.fieldset-legend-prefix').html(Drupal.t('Hide'));
    $content.slideDown({
      duration: 'fast',
      easing: 'linear',
      complete: function () {
        Drupal.collapseScrollIntoView(fieldset);
        fieldset.animating = false;
      },
      step: function () {
        // Scroll the fieldset into view.
        Drupal.collapseScrollIntoView(fieldset);
      }
    });
  }
  else {
    $fieldset.trigger({ type: 'collapsed', value: true });
    $('> .fieldset-wrapper', fieldset).slideUp('fast', function () {
      $fieldset
        .addClass('collapsed')
        .find('> legend span.fieldset-legend-prefix').html(Drupal.t('Show'));
      fieldset.animating = false;
    });
  }
};

/**
 * Scroll a given fieldset into view as much as possible.
 */
Drupal.collapseScrollIntoView = function (node) {
  var h = document.documentElement.clientHeight || document.body.clientHeight || 0;
  var offset = document.documentElement.scrollTop || document.body.scrollTop || 0;
  var posY = $(node).offset().top;
  var fudge = 55;
  if (posY + node.offsetHeight + fudge > h + offset) {
    if (node.offsetHeight > h) {
      window.scrollTo(0, posY);
    }
    else {
      window.scrollTo(0, posY + node.offsetHeight - h + fudge);
    }
  }
};

Drupal.behaviors.collapse = {
  attach: function (context, settings) {
    $('fieldset.collapsible', context).once('collapse', function () {
      var $fieldset = $(this);
      // Expand fieldset if there are errors inside, or if it contains an
      // element that is targeted by the URI fragment identifier.
      var anchor = location.hash && location.hash != '#' ? ', ' + location.hash : '';
      if ($fieldset.find('.error' + anchor).length) {
        $fieldset.removeClass('collapsed');
      }

      var summary = $('<span class="summary"></span>');
      $fieldset.
        bind('summaryUpdated', function () {
          var text = $.trim($fieldset.drupalGetSummary());
          summary.html(text ? ' (' + text + ')' : '');
        })
        .trigger('summaryUpdated');

      // Turn the legend into a clickable link, but retain span.fieldset-legend
      // for CSS positioning.
      var $legend = $('> legend .fieldset-legend', this);

      $('<span class="fieldset-legend-prefix element-invisible"></span>')
        .append($fieldset.hasClass('collapsed') ? Drupal.t('Show') : Drupal.t('Hide'))
        .prependTo($legend)
        .after(' ');

      // .wrapInner() does not retain bound events.
      var $link = $('<a class="fieldset-title" href="#"></a>')
        .prepend($legend.contents())
        .appendTo($legend)
        .click(function () {
          var fieldset = $fieldset.get(0);
          // Don't animate multiple times.
          if (!fieldset.animating) {
            fieldset.animating = true;
            Drupal.toggleFieldset(fieldset);
          }
          return false;
        });

      $legend.append(summary);
    });
  }
};

})(jQuery);
;
(function ($) {

Drupal.behaviors.menuFieldsetSummaries = {
  attach: function (context) {
    $('fieldset.menu-link-form', context).drupalSetSummary(function (context) {
      if ($('.form-item-menu-enabled input', context).is(':checked')) {
        return Drupal.checkPlain($('.form-item-menu-link-title input', context).val());
      }
      else {
        return Drupal.t('Not in menu');
      }
    });
  }
};

/**
 * Automatically fill in a menu link title, if possible.
 */
Drupal.behaviors.menuLinkAutomaticTitle = {
  attach: function (context) {
    $('fieldset.menu-link-form', context).each(function () {
      // Try to find menu settings widget elements as well as a 'title' field in
      // the form, but play nicely with user permissions and form alterations.
      var $checkbox = $('.form-item-menu-enabled input', this);
      var $link_title = $('.form-item-menu-link-title input', context);
      var $title = $(this).closest('form').find('.form-item-title input');
      // Bail out if we do not have all required fields.
      if (!($checkbox.length && $link_title.length && $title.length)) {
        return;
      }
      // If there is a link title already, mark it as overridden. The user expects
      // that toggling the checkbox twice will take over the node's title.
      if ($checkbox.is(':checked') && $link_title.val().length) {
        $link_title.data('menuLinkAutomaticTitleOveridden', true);
      }
      // Whenever the value is changed manually, disable this behavior.
      $link_title.keyup(function () {
        $link_title.data('menuLinkAutomaticTitleOveridden', true);
      });
      // Global trigger on checkbox (do not fill-in a value when disabled).
      $checkbox.change(function () {
        if ($checkbox.is(':checked')) {
          if (!$link_title.data('menuLinkAutomaticTitleOveridden')) {
            $link_title.val($title.val());
          }
        }
        else {
          $link_title.val('');
          $link_title.removeData('menuLinkAutomaticTitleOveridden');
        }
        $checkbox.closest('fieldset.vertical-tabs-pane').trigger('summaryUpdated');
        $checkbox.trigger('formUpdated');
      });
      // Take over any title change.
      $title.keyup(function () {
        if (!$link_title.data('menuLinkAutomaticTitleOveridden') && $checkbox.is(':checked')) {
          $link_title.val($title.val());
          $link_title.val($title.val()).trigger('formUpdated');
        }
      });
    });
  }
};

})(jQuery);
;
(function ($) {

Drupal.behaviors.pathFieldsetSummaries = {
  attach: function (context) {
    $('fieldset.path-form', context).drupalSetSummary(function (context) {
      var path = $('.form-item-path-alias input').val();
      var automatic = $('.form-item-path-pathauto input').attr('checked');

      if (automatic) {
        return Drupal.t('Automatic alias');
      }
      if (path) {
        return Drupal.t('Alias: @alias', { '@alias': path });
      }
      else {
        return Drupal.t('No alias');
      }
    });
  }
};

})(jQuery);
;
/**
 * @file
 * Custom JS for controlling the Metatag vertical tab.
 */

(function ($) {
  'use strict';

Drupal.behaviors.metatagFieldsetSummaries = {
  attach: function (context) {
    $('fieldset.metatags-form', context).drupalSetSummary(function (context) {
      var vals = [];
      $("input[type='text'], select, textarea", context).each(function() {
        var input_field = $(this).attr('name');
        // Verify the field exists before proceeding.
        if (input_field === undefined) {
          return false;
        }
        var default_name = input_field.replace(/\[value\]/, '[default]');
        var default_value = $("input[type='hidden'][name='" + default_name + "']", context);
        if (default_value.length && default_value.val() === $(this).val()) {
          // Meta tag has a default value and form value matches default value.
          return true;
        }
        else if (!default_value.length && !$(this).val().length) {
          // Meta tag has no default value and form value is empty.
          return true;
        }
        var label = $("label[for='" + $(this).attr('id') + "']").text();
        vals.push(Drupal.t('@label: @value', {
          '@label': $.trim(label),
          '@value': Drupal.truncate($(this).val(), 25) || Drupal.t('None')
        }));
      });
      if (vals.length === 0) {
        return Drupal.t('Using defaults');
      }
      else {
        return vals.join('<br />');
      }
    });
  }
};

/**
 * Encode special characters in a plain-text string for display as HTML.
 */
Drupal.truncate = function (str, limit) {
  if (str.length > limit) {
    return str.substr(0, limit) + '...';
  }
  else {
    return str;
  }
};

})(jQuery);
;

(function ($) {

Drupal.behaviors.xmlsitemapFieldsetSummaries = {
  attach: function (context) {
    $('fieldset#edit-xmlsitemap', context).drupalSetSummary(function (context) {
      var vals = [];

      // Inclusion select field.
      var status = $('#edit-xmlsitemap-status option:selected').text();
      vals.push(Drupal.t('Inclusion: @value', { '@value': status }));

      // Priority select field.
      var priority = $('#edit-xmlsitemap-priority option:selected').text();
      vals.push(Drupal.t('Priority: @value', { '@value': priority }));

      return vals.join('<br />');
    });
  }
};

})(jQuery);
;

(function ($) {

Drupal.behaviors.commentFieldsetSummaries = {
  attach: function (context) {
    $('fieldset.comment-node-settings-form', context).drupalSetSummary(function (context) {
      return Drupal.checkPlain($('.form-item-comment input:checked', context).next('label').text());
    });

    // Provide the summary for the node type form.
    $('fieldset.comment-node-type-settings-form', context).drupalSetSummary(function(context) {
      var vals = [];

      // Default comment setting.
      vals.push($(".form-item-comment select option:selected", context).text());

      // Threading.
      var threading = $(".form-item-comment-default-mode input:checked", context).next('label').text();
      if (threading) {
        vals.push(threading);
      }

      // Comments per page.
      var number = $(".form-item-comment-default-per-page select option:selected", context).val();
      vals.push(Drupal.t('@number comments per page', {'@number': number}));

      return Drupal.checkPlain(vals.join(', '));
    });
  }
};

})(jQuery);
;

(function ($) {

Drupal.behaviors.nodeFieldsetSummaries = {
  attach: function (context) {
    $('fieldset.node-form-revision-information', context).drupalSetSummary(function (context) {
      var revisionCheckbox = $('.form-item-revision input', context);

      // Return 'New revision' if the 'Create new revision' checkbox is checked,
      // or if the checkbox doesn't exist, but the revision log does. For users
      // without the "Administer content" permission the checkbox won't appear,
      // but the revision log will if the content type is set to auto-revision.
      if (revisionCheckbox.is(':checked') || (!revisionCheckbox.length && $('.form-item-log textarea', context).length)) {
        return Drupal.t('New revision');
      }

      return Drupal.t('No revision');
    });

    $('fieldset.node-form-author', context).drupalSetSummary(function (context) {
      var name = $('.form-item-name input', context).val() || Drupal.settings.anonymous,
        date = $('.form-item-date input', context).val();
      return date ?
        Drupal.t('By @name on @date', { '@name': name, '@date': date }) :
        Drupal.t('By @name', { '@name': name });
    });

    $('fieldset.node-form-options', context).drupalSetSummary(function (context) {
      var vals = [];

      $('input:checked', context).parent().each(function () {
        vals.push(Drupal.checkPlain($.trim($(this).text())));
      });

      if (!$('.form-item-status input', context).is(':checked')) {
        vals.unshift(Drupal.t('Not published'));
      }
      return vals.join(', ');
    });
  }
};

})(jQuery);
;
