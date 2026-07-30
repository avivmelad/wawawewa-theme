/**
 * File particles.js.
 *
 * Ambient connected-particle network drawn on the homepage's fixed
 * background canvas (`[data-particles]`). Purely decorative — skipped
 * entirely under prefers-reduced-motion.
 */
( function() {
	const canvas = document.querySelector( '[data-particles]' );

	if ( ! canvas || window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
		return;
	}

	const ctx = canvas.getContext( '2d' );
	const PARTICLE_COUNT = 46;
	const LINK_DISTANCE = 130;
	let width, height, particles, raf;

	function resize() {
		width = canvas.width = canvas.offsetWidth;
		height = canvas.height = canvas.offsetHeight;
	}

	function init() {
		resize();
		particles = Array.from( { length: PARTICLE_COUNT }, function() {
			return {
				x: Math.random() * width,
				y: Math.random() * height,
				vx: ( Math.random() - 0.5 ) * 0.25,
				vy: ( Math.random() - 0.5 ) * 0.25,
			};
		} );
	}

	function draw() {
		ctx.clearRect( 0, 0, width, height );

		particles.forEach( function( p ) {
			p.x += p.vx;
			p.y += p.vy;
			if ( p.x < 0 || p.x > width ) {
				p.vx *= -1;
			}
			if ( p.y < 0 || p.y > height ) {
				p.vy *= -1;
			}
		} );

		for ( let i = 0; i < PARTICLE_COUNT; i++ ) {
			for ( let j = i + 1; j < PARTICLE_COUNT; j++ ) {
				const a = particles[ i ];
				const b = particles[ j ];
				const distance = Math.hypot( a.x - b.x, a.y - b.y );

				if ( distance < LINK_DISTANCE ) {
					// Brighter/thicker than the v1 dark-canvas version — the lines
					// need more contrast now that they sit over a light background.
					ctx.strokeStyle = 'rgba(184,137,46,' + ( 0.32 * ( 1 - distance / LINK_DISTANCE ) ) + ')';
					ctx.lineWidth = 1.4;
					ctx.beginPath();
					ctx.moveTo( a.x, a.y );
					ctx.lineTo( b.x, b.y );
					ctx.stroke();
				}
			}
		}

		ctx.fillStyle = '#b8892e';
		particles.forEach( function( p ) {
			ctx.beginPath();
			ctx.arc( p.x, p.y, 1.6, 0, Math.PI * 2 );
			ctx.fill();
		} );

		raf = requestAnimationFrame( draw );
	}

	init();
	draw();

	window.addEventListener( 'resize', resize );
	window.addEventListener( 'beforeunload', function() {
		cancelAnimationFrame( raf );
	} );
}() );
