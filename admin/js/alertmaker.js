 // Function to handle responses and display SweetAlert
 function handleResponse(response) {
    switch(response) {
        case '200':
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'File uploaded successfully.',
            }).then(() => {
                location.reload(); // Reload the page after closing the alert
            });
            break;
        case '202':
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'File Updated successfully.',
                }).then(() => {
                    location.reload(); // Reload the page after closing the alert
                });
                break;
        case '203':
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'File Deleted successfully.',
                    }).then(() => {
                        location.reload(); // Reload the page after closing the alert
                    });
                    break;
        case '300':
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Added successfully.',
            }).then(() => {
                location.reload(); // Reload the page after closing the alert
            });
            break;
        case '301':
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Updated successfully.',
                }).then(() => {
                    location.reload(); // Reload the page after closing the alert
                });
                break;
        case '302':
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Deleted successfully.',
            }).then(() => {
                location.reload(); // Reload the page after closing the alert
            });
            break;
        case '403':
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Problem occurs.',
            });
            break;
        case 'error':
            Swal.fire({
                icon: 'error',
                title: 'Upload Failed',
                text: 'An error occurred while uploading. Please try again.',
            });
            break;
        default:
            Swal.fire({
                icon: 'warning',
                title: 'Unexpected Response',
                text: response,
            });
            break;
    }
}