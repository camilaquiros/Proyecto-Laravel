window.addEventListener('load', function(){
	console.log('hola');
	var elFormulario = document.querySelector('.formulario');
	console.log(elFormulario);
	var losCampos = Array.from(elFormulario.elements);
	console.log(losCampos);
	losCampos.pop();
	console.log(losCampos);

	var regexEmail = /\S+@\S+\.\S+/;
	var errores = {};
	losCampos.forEach(function (unCampo) {
	var divError = null;
	if (unCampo.type !== 'file') {
			divError = unCampo.nextElementSibling;
			console.log()
		} else {
			divError = unCampo.parentElement.nextElementSibling;
		}

		unCampo.addEventListener('blur', function () {
			var valorDelCampo = unCampo.value.trim();

			if (valorDelCampo === '') {
				this.classList.add('invalid-feedback');
				divError.style.display = 'block';
				divError.innerText = `Este campo es obligatorio`;

				errores[this.name] = true;
			}
			else {
				this.classList.remove('invalid-feedback');
				divError.style.display = 'none';
				divError.innerText = '';
				delete errores[this.name];

				// if (this.name === 'email') {
				// 	if (!regexEmail.test(valorDelCampo)) {
				// 		this.classList.add('invalid-feedback');
				// 		divError.style.display = 'block';
				// 		divError.innerText = `Ingresá un email válido`;
				// 		errores[this.name] = true;
				// 	} else {
				// 		this.classList.remove('invalid-feedback');
				// 		divError.style.display = 'none';
				// 		divError.innerText = '';
				// 	}
				// }
				if (this.name === 'email') {
					// valido que el texto sea un formato de email válido
					if (!regexEmail.test(valorDelCampo)) {
						this.classList.add('invalid-feedback'); // agrego clase is-invalid
						divError.style.display = 'block'; // muestro el div del error
						divError.innerText = `Ingresá un email válido`; // seteo el texto del error en si

						// Sumar una key al objeto de errores
						errores[this.name] = true;
					} else {
						// Si es un formato de email válido
						this.classList.remove('is-invalid');
						divError.style.display = 'none';
						divError.innerText = '';
					}
				}
				if (this.name === 'username' ) {
					if ( this.value.length < 8 ) {
						this.classList.add('invalid-feedback');
						divError.style.display = 'block';
						divError.innerText = `El nombre de usuario debe contener como mínimo 8 caracteres`;
						errores[this.name] = true;
					} else {
						this.classList.remove('invalid-feedback');
						divError.style.display = 'none';
						divError.innerText = '';
					}
				}
	      if (this.name === 'password') {
					if ( this.value.length < 8 ) {
						this.classList.add('invalid-feedback');
						divError.style.display = 'block';
						divError.innerText = `La contraseña debe contener como mínimo 8 caracteres`;
						errores[this.name] = true;
					} else {
						this.classList.remove('invalid-feedback');
						divError.style.display = 'none';
						divError.innerText = '';
					}
				}
				if (this.name === 'password_confirmation' ) {
					if ( this.value.length < 8 ) {
						this.classList.add('invalid-feedback');
						divError.style.display = 'block';
						divError.innerText = `La contraseña debe contener como mínimo 8 caracteres`;
						errores[this.name] = true;
					} else {
						this.classList.remove('invalid-feedback');
						divError.style.display = 'none';
						divError.innerText = '';
					}
				}
}


			console.log(errores);
		});

	});


	elFormulario.addEventListener('submit', function (event) {
		losCampos.forEach(function (unCampo) {
			var valorFinalDelCampo = unCampo.value.trim();

			if (valorFinalDelCampo === '') {
				errores[unCampo.name] = true;
			}
		});

		if (Object.keys(errores).length > 0) {
			alert('Campos vacíos');
			console.log(errores);
			event.preventDefault();
		}
	})

})
