<span class="subtitulo iniciar">Iniciar sesion</span> 
<?php
// split the username and password so we can put the form links were we want (they are in the "user-login-links" div bellow)
print drupal_render($form['name']);
print drupal_render($form['pass']);
?>
<!-- <div class="user-login-links">
<span class="password-link"><a href="/user/password">Forget your password?</a></span> | <span class="register-link"><a href="/user/register">Create an account</a></span>
</div> -->
<?php
// render login button
print drupal_render($form['form_build_id']);
print drupal_render($form['form_id']);
print drupal_render($form['actions']);
?>

<style>
	#edit-name, #edit-pass{
		padding: 10px;
		display: block;
		margin: 0 auto;
		font-size: 18px;
		border: none;
		border-bottom: 1px solid #ccc;
		outline: none;
		text-align: center;
		width: 380px;
		font-family: "BebasNeue-regular";
	}
	label, .tabs.primary, h1.title, .description{
		display: none;
	}
	.container{
		height: 800px;
	}
	span.iniciar{
		display: block;
	    margin: 30px auto;
	    width: 98px;
	    font-size: 20px;
	    padding: 5px 20px;
	}
	#edit-submit{
	    content: "Lo quiero!";
	    font-size: 18px;
	    z-index: 2;
	    background: #7dbebd;
	    color: #fff;
	    padding: 5px 9px;
	    border: none;
	    border-radius: 5px;
	    outline: none;
	    cursor: pointer;
	    font-family: 'Raleway', sans-serif;
	    font-weight: 100;
	    box-shadow: -3px 3px 0px #535f6d;
	    margin: 30px auto 0;
	    display: block;
	}
</style>

<script>
	$("#edit-name").attr("placeholder", "Correo electronico");
	$("#edit-pass").attr("placeholder", "Contraseña");
</script>