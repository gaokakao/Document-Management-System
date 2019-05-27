function validateKey(type)
{
	var key = window.event.keyCode;
	var valid = false;

	if (type == 'numeric')
	{
		// Skaiciai
		if ((key > 47) & (key < 58))
			valid = true;
	}
	else if (type == 'alpha')
	{
		// Didziosios raides
		if ((key > 64) & (key < 91))
			valid = true;
		// Mazosios raides
		if ((key > 96) & (key < 123))
			valid = true;
		// Skaiciai
		if ((key > 47) & (key < 58))
			valid = true;
		// Lietuviskos
		if ((key == 260) | (key == 261) |
		    (key == 268) | (key == 269) |
		    (key == 278) | (key == 279) |
		    (key == 280) | (key == 281) |
		    (key == 302) | (key == 303) |
		    (key == 352) | (key == 353) |
		    (key == 362) | (key == 363) |
		    (key == 370) | (key == 371) |
		    (key == 381) | (key == 382))
		 	valid = true;
		// Kita
		if ((key == 32) | (key == 33) |
		    (key == 39) | (key == 40) |
		    (key == 41) | (key == 45) |
		    (key == 44) | (key == 46) |
		    (key == 63) | (key == 95))
		 	valid = true;
	}

	if (!valid)
		window.event.keyCode = '';
}