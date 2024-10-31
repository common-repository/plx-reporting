/*
* Push to Data Layer on CF7 form sent
*/
document.addEventListener("wpcf7mailsent", function(e){
    const data = {
        "event": 'plx_form',
        "plx_data": e.detail.contactFormId,
        "plx_form_name": e.detail.formData.get('_plx_reporting_form_title'),
        "plx_enquiry_type": e.detail.formData.get('_plx_reporting_form_type'),
    };

   dataLayer.push(data);
});