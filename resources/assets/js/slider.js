let carousel = document.querySelector('.carousels');
let span = document.getElementsByTagName('span');
let product = document.getElementsByClassName('product');
let product_page = Math.ceil(product.length / 4);
let l = 0;
let movePer = 25.34;
let maxMove = 203;
let contador = 0; 

// mobile_view	
let mob_view = window.matchMedia("(max-width: 768px)");
if (mob_view.matches) {
	movePer = 50.36;
	maxMove = 504;
}

let right_mover = () => {	
	l = l + movePer;
	if(contador == product.length){
		console.log("Derecha llego al limite");
		l = l + movePer;
	}
	if(l > maxMove){
		carousel.appendChild(carousel.firstChild);
		l = l + movePer;
		l = 0;
	}
	if (product == 1) { l = 0; }
	for (const i of product) {
		if (l > maxMove) { 
			carousel.appendChild(carousel.firstChild);
			// l = l - movePer; 
		}
		i.style.left = '-' + l + '%';
	}
	contador++;
}
let left_mover = () => {
	l = l - movePer;
	if (l <= 0) { 
		carousel.prepend(carousel.lastElementChild); 
		l = 0;
	}
	for (const i of product) {
		if (product_page > 1) {
			i.style.left = '-' + l + '%';
		}
	}
}
span[2].onclick = () => { right_mover(); }
span[1].onclick = () => { left_mover(); }