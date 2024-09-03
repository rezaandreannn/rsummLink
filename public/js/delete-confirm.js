// Event delegation to handle clicks on dynamically loaded elements
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(event) {
        // Check if the clicked element has the attribute 'confirm-delete'
        if (event.target.closest('[confirm-delete="true"]')) {
            event.preventDefault();

            // Get the closest element with the attribute 'confirm-delete' and retrieve the data-id
            var element = event.target.closest('[confirm-delete="true"]');
            var deleteId = element.getAttribute('data-id');

            // Display the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Apakah Kamu Yakin?'
                , text: "Anda tidak akan dapat mengembalikan ini!"
                , icon: 'warning'
                , showCancelButton: true
                , confirmButtonColor: '#6777EF'
                , cancelButtonColor: '#d33'
                , confirmButtonText: 'Ya, Hapus saja!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Find the form and submit it if it exists
                    var form = document.getElementById('delete-form-' + deleteId);
                    if (form) {
                        form.submit();
                    } else {
                        console.error('Form not found for ID:', deleteId);
                    }
                }
            });
        }
    });
});

