const tilt = document.querySelectorAll(".tilt");

VanillaTilt.init(tilt, {
	reverse: false,
	max: 12,
	speed: 1000,
	scale: 1.05,
	glare: false,
	reset: true,
	perspective: 500,
	transition: true,
	"max-glare": 0.25,
	"glare-prerender": false,
	gyroscope: true,
	gyroscopeMinAngleX: -30,
	gyroscopeMaxAngleX: 30,
	gyroscopeMinAngleY: -30,
	gyroscopeMaxAngleY: 30
});