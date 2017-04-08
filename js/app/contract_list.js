$(document).ready(function() {
	var contract_listtManager = new Contract_ListManager({
		ajaxURL: contract_list_ajax_url,
		dataURL: data_url,
		pdfImage: pdf_image,
		noPdfImage: no_pdf_image
	});
});
/*** End of File /js/app/contract_list.js ***/