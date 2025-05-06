/**
 * Add Permission Modal JS
 */

'use strict';

// Add permission form validation
document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    const addPermissionForm = document.getElementById('addPermissionForm');
    const fv = FormValidation.formValidation(addPermissionForm, {
      fields: {
        modalPermissionName: {
          validators: {
            notEmpty: {
              message: 'Please enter permission name'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          // eleInvalidClass: '',
          eleValidClass: '',
          rowSelector: '.col-12'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        // Submit the form when all fields are valid
        // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    });
    $(addPermissionForm).on('click', '.createPermissionBtn', function (e) {
      e.preventDefault();
      fv.validate().then(function(status){
        if(status === 'Valid'){
          const formData = new FormData(addPermissionForm);
          for (let [key, value] of formData.entries()) {
            console.log(`Key: ${key}, Value: ${value}`);
          }
          $.ajax({
            url : permissionsStoreURL ,
            type : "POST" ,
            data : formData ,
            processData: false,
            contentType: false,
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Proper header
            },
            success : function(response){
              $('#addPermissionModal').modal('hide');
              if (typeof window.dt_permission !== 'undefined') {
                window.dt_permission.ajax.reload(); 
              } else {
                console.warn('DataTable (dt_permission) is not defined or initialized.');
                location.reload();
              }
            },
            error : function(xhr){
              let errorMessage = 'An error occurred while creating the permission.';
              if (xhr.status === 422) {
                  const errors = xhr.responseJSON.errors;
                  errorMessage = Object.values(errors).flat().join('\n');
              } else if (xhr.responseJSON && xhr.responseJSON.message) {
                  errorMessage = xhr.responseJSON.message;
              }
              alert(errorMessage);
            }
          });
        }
      });
    });
  })();
});
