/**
 * Add new role Modal JS
 */

'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
  
  (function () {
    // Get the form and modal elements
    const addRoleForm = document.querySelector('#addRoleForm');
    const addRoleModal = document.querySelector('#addRoleModal');
    const roleTitle = document.querySelector('.role-title');
    const roleAdd = document.querySelector('.add-new-role');

    if (!addRoleForm) {
      console.error('Form element #addRoleForm not found.');
      return;
    }

    if (!addRoleModal) {
      console.error('Modal element #addRoleModal not found.');
      return;
    }
    // Define refreshModal
    function refreshModal() {
      console.log('Add Role Modal JS loaded');
      const submitBtn = document.querySelector('.submitBtn');
      if (submitBtn) {
        submitBtn.classList.remove('data-update');
        submitBtn.classList.add('data-submit');
      } else {
        console.error('Submit button .submitBtn not found.');
      }
      document.querySelector('#modalRoleName').value = '';
      const checkboxList = document.querySelectorAll('[type="checkbox"]');
      checkboxList.forEach(checkbox => {
        if (checkbox.id !== 'selectAll') {
          checkbox.checked = false;
        }
      });
      if (addRoleForm) {
        addRoleForm.removeAttribute('data-role-id');
      }
      if (roleTitle) {
        roleTitle.innerHTML = 'Add New Role';
      }
      const errorSpan = document.querySelector('#modalRoleNameError');
      if (errorSpan) {
        errorSpan.textContent = '';
      }
    }
    // Add role form validation
    const fv = FormValidation.formValidation(addRoleForm, {
      fields: {
        modalRoleName: {
          validators: {
            notEmpty: {
              message: 'Please enter role name'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: '.col-12'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    });

    // Select All checkbox click
    const selectAll = document.querySelector('#selectAll');
    selectAll.addEventListener('change', (t) => {
      const checkboxList = document.querySelectorAll('[type="checkbox"]');
      checkboxList.forEach((e) => {
        e.checked = t.target.checked;
      });
    });
    // Add New Role click handler
    if (roleAdd) {
      roleAdd.onclick = function () {
        $('#addRoleModal').modal('show');
      };
    }
    if (roleAdd) {
      roleAdd.addEventListener('click', function () {
        console.log('Add New Role button clicked');
        refreshModal();
        $('#addRoleModal').modal('show');
      });
    }

    // Handle submit button click for adding new roles
    $(addRoleForm).on('click', '.submitBtn.data-submit', function (e) {
      e.preventDefault();
      console.log('Add Submit button clicked');

      // Check if this is an update operation (handled by modal-update-role.js)
      const roleId = $(addRoleForm).data('role-id');
      if (roleId) {
        return; // Let the update script handle it
      }

      fv.validate().then(function (status) {
        console.log('Validation status:', status);

        if (status === 'Valid') {
          const formData = new FormData(addRoleForm);
          const permissions = [];

          const checkboxList = document.querySelectorAll('[type="checkbox"]');
          checkboxList.forEach((checkbox) => {
            if (checkbox.checked && checkbox.id !== 'selectAll') {
              permissions.push(checkbox.value);
            }
          });

          formData.append('permissions', JSON.stringify(permissions));

          console.log('Add URL:', rolesStoreURL);
          for (let [key, value] of formData.entries()) {
            console.log(`Key: ${key}, Value: ${value}`);
          }

          $.ajax({
            url: rolesStoreURL,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
              console.log('AJAX Success:', response);
              if (response.success) {
                alert('Role added successfully');
                $('#addRoleModal').modal('hide');
                if (typeof window.dt_roles !== 'undefined') {
                  window.dt_roles.ajax.reload();
                } else {
                  location.reload();
                }
              } else {
                alert('Error: ' + (response.message || 'Failed to add role'));
              }
            },
            error: function (xhr) {
              console.error('AJAX Error:', xhr);
              let errorMessage = 'An error occurred while adding the role.';
              if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                errorMessage = Object.values(errors).flat().join('\n');
              } else if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
              }
              alert(errorMessage);
            }
          });
        } else {
          alert('Please fix the validation errors.');
        }
      }).catch(function (error) {
        console.error('Validation Error:', error);
        alert('An error occurred during validation.');
      });
    });
  })();
  $(document).on('click','.role-edit-modal',function(){
    var id = $(this).data('id');
    const submitBtn = $('.submitBtn');
    submitBtn.removeClass('data-submit');
    submitBtn.addClass('data-update');
    //alert(id);

    $.ajax({
      url : rolesEditURL.replace(':id',id) ,
      type : "GET",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
      },
      success : function(response){
        $('#modalRoleId').val(response.role.id);
        $('#modalRoleName').val(response.role.name);
        $('.role-title').text('Edit Role');
        $('input[name^="permission"]').prop('checked', false);
        if (response.permissions && response.permissions.length > 0) {
            response.permissions.forEach(function (permission) {
                $(`input[name="permission[${permission}]"]`).prop('checked', true);
            });
        }
        // Show the modal
        var myModal = new bootstrap.Modal(document.getElementById('addRoleModal'));
        myModal.show();
      },
      error : function(xhr){
        alert("An error occurred while fetching the role data.");
            console.error(xhr);
      }
    });
  });
  $(document).on('click', '.submitBtn.data-update', function () {
    var formData = $('#addRoleForm').serializeArray();
    var roleId = $('#modalRoleId').val();
    var roleName = $('#modalRoleName').val();
    var permissions = [];

    // Collect checked permissions
    $('input[name^="permission"]:checked').each(function () {
        permissions.push($(this).val());
    });

    $.ajax({
        url: rolesUpdateURL.replace(':id', roleId), 
        type: "PUT",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            name: roleName,
            permissions: permissions
        },
        success: function (response) {
          console.log('AJAX Success:', response);
              if (response.success) {
                alert('Role Updated successfully');
                $('#addRoleModal').modal('hide');
                if (typeof window.dt_roles !== 'undefined') {
                  window.dt_roles.ajax.reload();
                } else {
                  location.reload();
                }
              } else {
                alert('Error: ' + (response.message || 'Failed to add role'));
              }
        },
        error: function (xhr) {
            alert('An error occurred while updating the role.');
            console.error(xhr);
        }
    });
});
$(document).on('click', '.role-delete', function () {
  var id = $(this).data('id');
  if (confirm('Are you sure you want to delete this role?')) {
    $.ajax({
      url: rolesDeleteURL.replace(':id', id), // Define rolesDeleteURL in your Blade
      type: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (response) {
        console.log('Delete AJAX Success:', response);
        alert('Role deleted successfully');
        if (typeof window.dt_roles !== 'undefined') {
          window.dt_roles.ajax.reload();
        } else {
          location.reload();
        }
      },
      error: function (xhr) {
        console.error('Delete AJAX Error:', xhr);
        alert('An error occurred while deleting the role.');
      }
    });
  }
});
});