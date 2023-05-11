<?php
return [
	'client_id' => 'AbpdDepCEEU84XtgW_yk2_lW1RoksyIr38qMygMdnrBeFCx_q0oLWXIDT8ZSZBqE37XzaHDH8Ao2C1gd',
	'secret' => 'ENwFNGVSAWVoF9sjtxDpkEaefOgvMDshkcolKymmCaycIcH-zhVV7OfllZ1lNiQ_Foh8Hdsu5xo0cajM',
	/*'client_id' => 'AbtnNlHxh11LSArDbvox94kl1kwXPUDbMklFirHY_kfv3XnbGoB1_zdxKqXVvjFO4qzQEXWdSv2Qf9j9',
	'secret' => 'ELZo2rc7YaakIlhhc-S4btzXULsNbPBTT3oYEh5r0IAyBEQ9OJGnjjIsUQa-qnkAS2TpSEmger1o507Q',*/
	'settings' => [
		'mode' => 'sandbox',
		'http.ConnectionTimeOut' => 1000,
		'log.LogEnabled' => true,
		'log.FileName' => storage_path() . '/logs/paypal.log',
		'log.LogLevel' => 'FINE'
	],
];
