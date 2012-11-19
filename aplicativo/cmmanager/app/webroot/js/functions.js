/****EMAIL VALIDATION***/
	//function to check valid email address
	function isValidEmail(strEmail){
	  validRegExp = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/i;
	  // /^[^@]+@[^@]+.[^@][a-z]{2,}$/i;
	  //strEmail = $(strEmail).val();

	   // search email text for regular exp matches
	    if (strEmail.search(validRegExp) == -1)
	   {
	      return false;
	    }
	    return true;
	}
	/****NUMERIC VALIDATION***/
	function isValidNumeric(strNumeric){
	  validRegExp = /^([0-9]?)*$/i;

	   // search email text for regular exp matches
	    if (strNumeric.search(validRegExp) == -1)
	   {
	      return false;
	    }
	    return true;
	}
	/****PHONE VALIDATION***/
	function isValidPhone(strPhone){
	  validRegExp = /^\+([0-9]?)*$/i;

	   // search email text for regular exp matches
	    if (strPhone.search(validRegExp) == -1)
	   {
	      return false;
	    }
	    return true;
	}
	/****MAX100 VALIDATION***/
	function isMin100(strNumber){
	    if (strNumber > 100)
	   {
	      return false;
	    }
	    return true;
	}
	/****FORM VALIDATION***/
	function validateForm(y){
		jQuery("span.error").html('');
		var error = false;
		jQuery("#"+y).find('.requiredField').each(function(index){
			if(jQuery(this).val() == ""){
				jQuery(this).parent().find('.error').html('Este campo es requerido');
				error = true;
			} else if(jQuery(this).hasClass("email") && !isValidEmail(jQuery(this).val())) {
				jQuery(this).parent().find('.error').html('La direccion de correo no es valida');
				error = true;
			} else if(jQuery(this).hasClass("numeric") && !isValidNumeric(jQuery(this).val())) {
				jQuery(this).parent().find('.error').html('Solo se aceptan numeros');
				error = true;
			} else if(jQuery(this).hasClass("phone") && !isValidPhone(jQuery(this).val())) {
				jQuery(this).parent().find('.error').html('El formato de numero telefonico no es valido');
				error = true;
			} else if(jQuery(this).hasClass("max100") && !isMin100(jQuery(this).val())) {
				jQuery(this).parent().find('.error').html('El maximo es de 100 caracteres');
				error = true;
			}
//			else {
//				return true;
//			}

		});
		if(error) return false;
		return true;
	}
