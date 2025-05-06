/**
 * Edit Permission Modal JS
 */

'use strict';
$(document).on('click','.editBtn',function(){
  const permissionData = $(this).data('permission');
      if (!permissionData) {
        console.error('Permission data not found.');
        return;
      }

      // Populate the form with permission data
      $('#editPermissionName').val(permissionData.name);
      // Store the permission ID in a hidden input or data attribute for the update request
      $(editPermissionForm).data('permission-id', permissionData.id);
});

// Edit permission form validation
document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    const editPermissionForm = document.getElementById('editPermissionForm');

     const fv = FormValidation.formValidation(editPermissionForm, {
      fields: {
        editPermissionName: {
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
          rowSelector: '.col-sm-9'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        // Submit the form when all fields are valid
        // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    });
    $(editPermissionForm).on('click', '.updateBtn', function (e) {
      e.preventDefault();


      fv.validate().then(function(status){
        if(status === 'Valid'){
          const formData = new FormData(editPermissionForm);
          const permissionId = $(editPermissionForm).data('permission-id')
          console.log("id"+permissionId)
          for (let [key, value] of formData.entries()) {
            console.log(`Key: ${key}, Value: ${value}`);
          }
          $.ajax({
            url : permissionEditURL.replace(':id',permissionId) ,
            type : "POST" ,
            data : formData ,
            processData: false,
            contentType: false,
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Proper header
            },
            success : function(response){
              $('#editPermissionModal').modal('hide');
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
