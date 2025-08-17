window.addEventListener('load', function(){
	
	const burger = document.getElementById('burger');
	const mainMenu = burger.nextElementSibling;

	burger.addEventListener('click', function(){
	  burger.classList.toggle('open');
	  mainMenu.classList.toggle('open');
	});
	
});