$(".drop-files-container").bind("drop", function(e) {
    var files = e.originalEvent.dataTransfer.files;
    processFileUpload(files); 
    // forward the file object to your ajax upload method
    return false;
});


function processFileUpload(droppedFiles) {
         // add your files to the regular upload form
    var uploadFormData = new FormData($("#yourregularuploadformId")[0]); 
    if(droppedFiles.length > 0) { // checks if any files were dropped
        for(var f = 0; f < droppedFiles.length; f++) { // for-loop for each file dropped
            uploadFormData.append("files[]",droppedFiles[f]);  // adding every file to the form so you could upload multiple files
        }
    }
	
	
	
	
	// the final ajax call

       $.ajax({
        url : "uploads.php", // use your target
        type : "POST",
        data : uploadFormData,
        cache : false,
        contentType : false,
        processData : false,
        success : function(ret) {
                 // callback function
        }
       });
