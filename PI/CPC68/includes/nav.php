<nav class="nav">
	<button class="hamburger" id="btSideNav">
      <span>OS 3 TRACINHOS QUE VAO SER ANIMADOS</span>
    </button>
	<span><a class="logo" href="telaPrincipal.php"><img width="128px" alt="" src="img/logo.png"></a></span>
	<div class="links">
		<a href="rel.php">Relatórios</a>
		<a href="#">Serviços</a>
		<a href="about.php">Sobre</a>
    	<div class="user">
        	<span><?php echo $_SESSION['nome'];?></span>
        	<a href='logout.php'>Logout</a>
    	</div>
	</div>
</nav>