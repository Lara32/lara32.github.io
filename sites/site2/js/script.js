window.onload=function(  ){


var btn=document.querySelector('.monitor .play');
	btn.style.cursor = 'pointer';
	btn.onclick = function(  ){
		this.style.display = 'none';
		this.parentNode.querySelector('.screen').style.opacity = 0;
		/* this.parentNode.style.marginTop = 0; */
		var video = this.parentNode.querySelector('.video');
		video.style.opacity = 1;
		video.innerHTML = '<iframe  src="https://www.youtube.com/embed/Lm_WmdLFceM?autoplay=1" frameborder="0" allowfullscreen></iframe>';
	
	};
}