/**
 * App eCommerce Add Product Script
 */
'use strict';

//Javascript to handle the e-commerce product add page

(function () {
  // Comment editor

  const commentEditor = document.querySelector('.comment-editor');
  let quill = null;
  if (commentEditor) {
    quill = new Quill(commentEditor, {
      modules: {
        toolbar: '.comment-toolbar'
      },
      placeholder: 'Product Description',
      theme: 'snow'
    });
  }
  
  // previewTemplate: Updated Dropzone default previewTemplate

  // ! Don't change it unless you really know what you are doing

  const previewTemplate = `<div class="dz-preview dz-file-preview">
<div class="dz-details">
  <div class="dz-thumbnail">
    <img data-dz-thumbnail>
    <span class="dz-nopreview">No preview</span>
    <div class="dz-success-mark"></div>
    <div class="dz-error-mark"></div>
    <div class="dz-error-message"><span data-dz-errormessage></span></div>
    <div class="progress">
      <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
    </div>
  </div>
  <div class="dz-filename" data-dz-name></div>
  <div class="dz-size" data-dz-size></div>
</div>
</div>`;

  // ? Start your code from here

  // Basic Dropzone

  const dropzoneBasic = document.querySelector('#dropzone-basic');
  if (dropzoneBasic) {
    const myDropzone = new Dropzone(dropzoneBasic, {
      previewTemplate: previewTemplate,
      parallelUploads: 1,
      maxFilesize: 5,
      acceptedFiles: '.jpg,.jpeg,.png,.gif',
      addRemoveLinks: true,
      maxFiles: 1
    });
  }

  // Basic Tags

  // const tagifyBasicEl = document.querySelector('#ecommerce-product-tags');
  // const TagifyBasic = new Tagify(tagifyBasicEl);

  // Flatpickr

  // Datepicker
  const date = new Date();

  const productDate = document.querySelector('.product-date');

  if (productDate) {
    productDate.flatpickr({
      monthSelectorType: 'static',
      defaultDate: date
    });
  }

  $(document).on('click','.publishBtn',function(e){
    e.preventDefault();
    
    const myDropzone = Dropzone.forElement("#dropzone-basic");
    const imageFiles = myDropzone.getAcceptedFiles();

    var formData = new FormData();

    formData.append('name', $('#ecommerce-product-name').val());
    formData.append('sku', $('#ecommerce-product-sku').val());
    formData.append('barcode', $('#ecommerce-product-barcode').val());
    formData.append('description', quill.root.innerHTML);
    formData.append('category_id', $('#category-org').val());
    formData.append('status', $('#status-org').val());
    formData.append('base_price', $('#ecommerce-product-price').val());
    formData.append('discounted_price', $('#ecommerce-product-discount-price').val());
    formData.append('charge_tax', $('#price-charge-tax').is(':checked') ? 1 : 0);
    formData.append('in_stock', $('#product-instock').is(':checked') ? 1 : 0);

    if (imageFiles.length > 0) {
      formData.append('image', imageFiles[0]);
    }
    
    for (let pair of formData.entries()) {
      console.log(`${pair[0]}:`, pair[1]);
  }
    
    $.ajax({
      url : storeProductURL ,
      type : "POST" ,
      data : formData,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Proper header
      },
      success : function(respponse){
        toastr.success('Product Created Successfully');
         // Reset the form fields
         $('#ecommerce-product-name').val('');
         $('#ecommerce-product-sku').val('');
         $('#ecommerce-product-barcode').val('');
         quill.setText(''); // Reset Quill editor content
         $('#category-org').val('').trigger('change'); // Reset category select2
         $('#status-org').val('').trigger('change'); // Reset status select2
         $('#ecommerce-product-price').val('');
         $('#ecommerce-product-discount-price').val('');
         $('#price-charge-tax').prop('checked', false); // Uncheck the checkbox
         $('#product-instock').prop('checked', false); // Uncheck the in-stock checkbox

         // Clear Dropzone files
         myDropzone.removeAllFiles(true);
      },
      error : function(xhr){
        if (xhr.status === 422) {
          var errors = xhr.responseJSON.errors;
          // Clear old error messages
          $('.text-danger').remove();
    
          // Show new error messages
          $.each(errors, function(key, messages) {
            const input = $('[name="' + key + '"]');
            if (input.length) {
              input.after('<div class="text-danger mt-1">' + messages[0] + '</div>');
            }
          });
        } else {
          toastr.error('Something went wrong. Please try again.');
        }
      },
      complete : function(){
        
      }
    });
    console.log("storeProductURL:", storeProductURL); 
  })
  
  //submit edit product
  $(document).on('click','.updateBtn',function(e){
    e.preventDefault();
    
    var id = $('#ecommerce-product-id').val();
    const myDropzone = Dropzone.forElement("#dropzone-basic");
    const imageFiles = myDropzone.getAcceptedFiles();

    var formData = new FormData();

    formData.append('name', $('#ecommerce-product-name').val());
    formData.append('sku', $('#ecommerce-product-sku').val());
    formData.append('barcode', $('#ecommerce-product-barcode').val());
    formData.append('description', quill.root.innerHTML);
    formData.append('category_id', $('#category-org').val());
    formData.append('status', $('#status-org').val());
    formData.append('base_price', $('#ecommerce-product-price').val());
    formData.append('discounted_price', $('#ecommerce-product-discount-price').val());
    formData.append('charge_tax', $('#price-charge-tax').is(':checked') ? 1 : 0);
    formData.append('in_stock', $('#product-instock').is(':checked') ? 1 : 0);

    if (imageFiles.length > 0) {
      formData.append('image', imageFiles[0]);
    }
    
    for (let pair of formData.entries()) {
      console.log(`${pair[0]}:`, pair[1]);
  }
    
    $.ajax({
      url : updateProductURL.replace(':id',id) ,
      type : "POST" ,
      data : formData,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Proper header
      },
      success : function(respponse){
        toastr.success('Product Updated Successfully');
      },
      error : function(xhr){
        if (xhr.status === 422) {
          var errors = xhr.responseJSON.errors;
          // Clear old error messages
          $('.text-danger').remove();
    
          // Show new error messages
          $.each(errors, function(key, messages) {
            const input = $('[name="' + key + '"]');
            if (input.length) {
              input.after('<div class="text-danger mt-1">' + messages[0] + '</div>');
            }
          });
        } else {
          toastr.error('Something went wrong. Please try again.');
        }
      },
      complete : function(){
        //window.location.href = '/product';
      }
    });
    console.log("UpdateProductURL:", updateProductURL); 
  }) 
})();

//Jquery to handle the e-commerce product add page

// $(function () {
//   // Select2
//   var select2 = $('.select2');
//   if (select2.length) {
//     select2.each(function () {
//       var $this = $(this);
//       $this.wrap('<div class="position-relative"></div>').select2({
//         dropdownParent: $this.parent(),
//         placeholder: $this.data('placeholder') // for dynamic placeholder
//       });
//     });
//   }

//   var formRepeater = $('.form-repeater');

//   // Form Repeater
//   // ! Using jQuery each loop to add dynamic id and class for inputs. You may need to improve it based on form fields.
//   // -----------------------------------------------------------------------------------------------------------------

//   if (formRepeater.length) {
//     var row = 2;
//     var col = 1;
//     formRepeater.on('submit', function (e) {
//       e.preventDefault();
//     });
//     formRepeater.repeater({
//       show: function () {
//         var fromControl = $(this).find('.form-control, .form-select');
//         var formLabel = $(this).find('.form-label');

//         fromControl.each(function (i) {
//           var id = 'form-repeater-' + row + '-' + col;
//           $(fromControl[i]).attr('id', id);
//           $(formLabel[i]).attr('for', id);
//           col++;
//         });

//         row++;
//         $(this).slideDown();
//         $('.select2-container').remove();
//         $('.select2.form-select').select2({
//           placeholder: 'Placeholder text'
//         });
//         $('.select2-container').css('width', '100%');
//         $('.form-repeater:first .form-select').select2({
//           dropdownParent: $(this).parent(),
//           placeholder: 'Placeholder text'
//         });
//         $('.position-relative .select2').each(function () {
//           $(this).select2({
//             dropdownParent: $(this).closest('.position-relative')
//           });
//         });
//       }
//     });
//   }
// });

//add-products functionality
