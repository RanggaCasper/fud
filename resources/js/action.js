$(document).on('submit', 'form', function(e) {
    if ($(this).data('action') === false) {
        return; // biarkan form submit secara default
    }
    
    e.preventDefault();

    $(this).find('input').removeClass('border-danger');
    $('.alert').remove();
    $('.error-message').remove();

    let button = $(this).find('button[type="submit"]');
    let buttonText = button.text();
    button.prop('disabled', true);
    button.html(`
        <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-1 text-light animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
        </svg>
        Loading...
    `);

    $.ajax({
        url: $(this).attr('action'),
        method: $(this).attr('method') || 'POST',
        data: $(this).serialize(),
        success: function(response) {
            if (response.status && response.message) {
                $(e.target).before(generateAlertHtml('success', response.message));
            }

            if (response.redirect_url) {
                window.location.href = response.redirect_url;
            }

            if ($.fn.DataTable) {
                $('.dataTable').each(function () {
                    if ($.fn.DataTable.isDataTable(this)) {
                        $(this).DataTable().ajax.reload(null, false);
                    }
                });
            }

            if ($(e.target).data('reset') !== false) {
                $(e.target).trigger('reset');
            }
    
            if ($(e.target).data('reload')) {
                location.reload();
            }
    
            if ($.fn.select2) {
                $('.select2').each(function () {
                    $(this).val(null).trigger('change');
                });
            }
            
            $.each($(e.target).data(), function(key, value) {
                if (typeof window[value] === 'function') {
                    try {
                        window[value]();
                    } catch (err) {
                        console.error(`Error saat memanggil fungsi dari data-${key}:`, err);
                    }
                }
            });
        },
        error: function(xhr) {
            let response = xhr.responseJSON;
            // console.info(response.message);
            let errors = response.errors;

            // Clear existing error messages
            $('.error-message').remove();

            if (response.message) {
                if (response.errors) {
                    $(e.target).before(generateAlertHtml('danger', response.errors));
                } else {
                    $(e.target).before(generateAlertHtml('danger', response.message));
                }
            }

            if (errors && typeof errors === 'object' && Object.keys(errors).length > 0) {
                // Iterate over field errors and display them below the inputs
                $.each(errors, function(field, message) {
                    let input = $(`[name="${field}"]`);
                    
                    let d = input.closest('.relative');
                    input.addClass('border-danger');
                    d.after(`
                        <div class="error-message text-xs text-danger mt-1">${message[0]}</div>
                    `);
                });
            } 

            // $(e.target).before(generateAlertHtml('danger', response.message));
            
        },
        complete: function() {  
            button.prop('disabled', false);
            button.html(`
                ${buttonText}
            `);
        }
    });
});

function generateAlertHtml(type, message) {
    const capitalize = (str) => str.charAt(0).toUpperCase() + str.slice(1);
    
    const alertClasses = type === 'success' ? 'bg-green-50 text-success border-success' :
                        (type === 'danger' ? 'bg-red-50 text-danger border-danger' :
                        (type === 'info' ? 'bg-blue-50 text-info border-info' :
                        'bg-yellow-50 text-warning border-warning'));

    
    return `
        <div class="alert flex items-center p-4 mb-4 text-sm ${alertClasses} border rounded-lg" role="alert">
            <i class="ti ti-info-circle text-lg me-1"></i>
            <div>
                ${message}
            </div>
        </div>
    `;
}