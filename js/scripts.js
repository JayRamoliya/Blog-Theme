jQuery(document).ready(function () {
    // Validate first name
    jQuery('#firstname').on('input', function () {
        let firstname = jQuery(this).val().trim();
        let alphabetRegex = /^[A-Za-z]+$/;

        if (firstname === '') {
            jQuery('#firstname-error').text('First name is required').show();
        } else if (!alphabetRegex.test(firstname)) {
            jQuery('#firstname-error').text('First name must contain only alphabets').show();
        } else {
            jQuery('#firstname-error').hide();
        }
    });


    // Validate last name
    jQuery('#lastname').on('input', function () {
        let lastname = jQuery(this).val().trim();
        let alphabetRegex = /^[A-Za-z]+$/;

        if (lastname === '') {
            jQuery('#lastname-error').text('Last name is required').show();
        } else if (!alphabetRegex.test(lastname)) {
            jQuery('#lastname-error').text('Last name must contain only alphabets').show();
        } else {
            jQuery('#lastname-error').hide();
        }
    });

    // Validate username
    jQuery('#username').on('input', function () {
        let username = jQuery(this).val().trim();
        if (username === '') {
            jQuery('#username-error').text('Username is required').show();
        } else {
            jQuery('#username-error').hide();
        }
    });

    // Validate email
    jQuery('#email').on('input', function () {
        let email = jQuery(this).val().trim();
        let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

        if (email === '') {
            jQuery('#email-error').text('Email is required').show();
        } else if (!emailPattern.test(email)) {
            jQuery('#email-error').text('Invalid email format').show();
        } else {
            jQuery('#email-error').hide();
        }
    });

    // Validate password
    jQuery('#password').on('input', function () {
        let password = jQuery(this).val().trim();
        // let passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
        if (password === '') {
            jQuery('#password-error').text('Password is required').show();
        } else if (password.length < 6) {
            jQuery('#password-error').text('Password must be at least 6 characters long').show();
        } else {
            jQuery('#password-error').hide();
        }
    });

    // Validate phone number
    jQuery('#phone').on('input', function () {
        let phone = jQuery(this).val().trim();
        let phonePattern = /^[0-9]{10}$/;
        if (phone !== '' && !phonePattern.test(phone)) {
            jQuery('#phone-error').text('Invalid phone number').show();
        } else {
            jQuery('#phone-error').hide();
        }
    });

    // Validate hobbies
    jQuery(document).ready(function () {
        jQuery('input[name="hobbies[]"]').on('click', function () {
            if (jQuery('input[name="hobbies[]"]:checked').length < 2) {
                jQuery('#hobbies-error').text('Please select at least two hobby').show();
            } else {
                jQuery('#hobbies-error').hide();
            }
        });
    });

    // Validate gender
    jQuery('#gender').on('change', function () {
        let gender = jQuery(this).val();
        if (gender === '') {
            jQuery('#gender-error').text('Gender is required').show();
        } else {
            jQuery('#gender-error').hide();
        }
    });

    // Final form submission validation
    jQuery('#signup-form').on('submit', function (e) {
        let isValid = true;
        jQuery('#signup-form input, #signup-form select').each(function () {
            jQuery(this).trigger('change');
            if (jQuery(this).siblings('.error-message').is(':visible')) {
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault();
        }
    });
});



// ==========================================================================================



function validateForm() {
    var firstname = jQuery('#firstname').val().trim();
    var lastname = jQuery('#lastname').val().trim();
    var username = jQuery('#username').val().trim();
    var email = jQuery('#email').val().trim();
    var password = jQuery('#password').val().trim();
    var phone = jQuery('#phone').val().trim();
    var gender = jQuery('#gender').val();

    // Validate First Name
    if (firstname === '') {
        jQuery('#firstname-error').text('First name is required');
        return false;
    } else {
        jQuery('#firstname-error').text('');
    }

    // Validate Last Name
    if (lastname === '') {
        jQuery('#lastname-error').text('Last name is required');
        return false;
    } else {
        jQuery('#lastname-error').text('');
    }

    // Validate Username
    if (username === '') {
        jQuery('#username-error').text('Username is required');
        return false;
    } else {
        jQuery('#username-error').text('');
    }

    // Validate Email
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email === '') {
        jQuery('#email-error').text('Email is required');
        return false;
    } else if (!emailRegex.test(email)) {
        jQuery('#email-error').text('Invalid email format');
        return false;
    } else {
        jQuery('#email-error').text('');
    }

    // Validate Password
    if (password === '') {
        jQuery('#password-error').text('Password is required');
        return false;
    } else {
        jQuery('#password-error').text('');
    }

    // Validate Phone Number (Assuming 10 digit number)
    var phoneRegex = /^\d{10}$/;
    if (phone === '') {
        jQuery('#phone-error').text('Phone number is required');
        return false;
    } else if (!phoneRegex.test(phone)) {
        jQuery('#phone-error').text('Invalid phone number');
        return false;
    } else {
        jQuery('#phone-error').text('');
    }

    // Validate Gender
    if (gender === '') {
        jQuery('#gender-error').text('Please select your gender');
        return false;
    } else {
        jQuery('#gender-error').text('');
    }

    // Validate Profile Photo
    var profilePhoto = jQuery('#profile-photo').val();
    if (profilePhoto === '') {
        jQuery('#profile-photo-error').text('Please upload a profile photo');
        return false;
    } else {
        jQuery('#profile-photo-error').text('');
    }

    // Validate Hobbies (At least one checkbox checked)
    var hobbies = jQuery('input[name="hobbies[]"]:checked');
    if (hobbies.length === 0) {
        jQuery('#hobbies-error').text('Please select at least one hobby');
        return false;
    } else {
        jQuery('#hobbies-error').text('');
    }

    // If all validations pass, return true to submit the form
    return true;
}



// ==========================================================================================



// this is a ajax_login_form ajax call here
// jQuery(document).ready(function () {
//     jQuery('form.ajax_login_form').on('submit', function (e) {
//         e.preventDefault();

//         var username = jQuery('#username').val().trim();
//         var password = jQuery('#password').val().trim();
//         jQuery.ajax({
//             url: my_ajax_object.ajax_url,
//             type: "post",
//             dataType: 'json',
//             data: {
//                 action: 'login_form',
//                 username: username,
//                 password: password,
//             },
//             // success: function(response) {
//             //     console.log(response.message);
//             // },

//             success: function (response) {
//                 console.log(response);
//                 if (response.success) {
//                     window.location.href = response.data.redirect;
//                 }
//             },
//         });
//     });
// });



// ==========================================================================================



// this is a ajax_signup_form ajax call here
jQuery(document).ready(function () {
    jQuery('form.ajax_signup_form').on('submit', function (e) {
        e.preventDefault();

        var photoid = jQuery('#photoid').val().trim();
        var firstname = jQuery('#firstname').val().trim();
        var lastname = jQuery('#lastname').val().trim();
        var username = jQuery('#username').val().trim();
        var email = jQuery('#email').val().trim();
        var password = jQuery('#password').val().trim();
        var phone = jQuery('#phone').val().trim();
        var gender = jQuery('#gender').val();
        var multihobbies = [];
        jQuery(':checkbox:checked').each(function (i) {
            multihobbies[i] = jQuery(this).val();
        });

        jQuery.ajax({
            url: my_ajax_object.ajax_url,
            type: "POST",
            dataType: 'json',
            data: {
                action: 'signup_form',
                photoid: photoid,
                firstname: firstname,
                lastname: lastname,
                username: username,
                password: password,
                email: email,
                phone: phone,
                gender: gender,
                multihobbies: multihobbies,
            },
            success: function (response) {
                // console.log(response);
                if (response.success) {
                    window.location.href = response.data.redirect;
                }
            },
        });
    });
});



// ==========================================================================================



// this is a ajax_edit_form ajax call here
jQuery(document).ready(function () {
    jQuery('form.ajax_edit_form').on('submit', function (e) {
        e.preventDefault()

        var firstname = jQuery('#firstname').val().trim();
        var lastname = jQuery('#lastname').val().trim();
        var username = jQuery('#username').val().trim();
        var email = jQuery('#email').val().trim();
        var phone = jQuery('#phone').val().trim();
        var gender = jQuery('#gender').val();
        var multihobbies = [];
        jQuery(':checkbox:checked').each(function (i) {
            multihobbies[i] = jQuery(this).val();
        });

        jQuery.ajax({
            url: my_ajax_object.ajax_url,
            type: "POST",
            dataType: 'json',
            data: {
                action: 'edit_form',
                firstname: firstname,
                lastname: lastname,
                username: username,
                email: email,
                phone: phone,
                gender: gender,
                multihobbies: multihobbies,
            },
            success: function (response) {
                // console.log(response);
                if (response.success) {
                    window.location.href = response.data.redirect;
                }
            },
        });
    })
})



// ==========================================================================================



// this is a ajax_file_upload ajax call here
jQuery('form.ajax_signup_form').on('submit', function (e) {
    jQuery('#profile-photo').on('change', function (e) {
        e.preventDefault;

        var formData = new FormData();
        formData.append('action', 'file_upload');
        formData.append('profile_photo', jQuery('#profile-photo')[0].files[0]);

        jQuery.ajax({
            url: my_ajax_object.ajax_url,
            type: "POST",
            dataType: 'json',
            data: formData,
            processData: false, // To send DOMDocument or non processed data file it is set to false
            contentType: false, // The content type used when sending data to the server
            success: function (response) {
                console.log(response.data);
                jQuery("input[name=photoid]").val(response.data.photoid)
            }
        });
    })
})



// ==========================================================================================



// this is a paginations ajax call here
function attachPaginationHandlers() {
    jQuery('.pagination a').off('click').on('click', function (e) {
        e.preventDefault();
        let href = jQuery(this).attr('href');

        jQuery.ajax({
            url: my_ajax_object.ajax_url,
            type: "POST",
            dataType: 'json',
            data: {
                action: 'paginations',
                href: href,
            },
            success: function (response) {
                if (response.success) {
                    const products = response.data.products;
                    const pagination = response.data.pagination;
                    console.log(products);
                    console.log(pagination);

                    let html = '';
                    products.forEach(function (product) {
                        if (product.message) {
                            html += '<p>' + product.message + '</p>';
                        } else {
                            html += '<div class="card" ' + (product.stock == 0 ? 'style="opacity: 0.5; pointer-events: none;"' : '') + '>';
                            html += '<div class="image"><img src="' + product.thumbnail + '" alt="' + product.title + '"></div>';
                            if (product.sale_price) {
                                html += '<p class="sale-price">Sale Price: ₹' + product.sale_price + '</p>';
                            }
                            if (product.product_price) {
                                html += '<p class="product-price">Price: ₹' + product.product_price + '</p>';
                            }
                            if (!product.stock) {
                                html += '<p class="outstock">Out of Stock</p>';
                            }
                            html += '<div class="content">';
                            html += '<a href="' + product.permalink + '"><span class="title">' + product.title + '</span></a>';
                            html += '<div id="category">';
                            product.categories.forEach(function (category) {
                                html += '<h3>' + category + '</h3>';
                            });
                            html += '</div></div></div>';
                        }
                    });

                    jQuery('.cards-container').html(html);
                    jQuery('.custom-pagination').html(pagination);

                    attachPaginationHandlers();
                } else {
                    console.log(response.data.message);
                }
            },
        });
    });
}


jQuery(document).ready(function () {
    attachPaginationHandlers();
});



// ==========================================================================================



// this is a ajax_addproducts ajax call here
// jQuery(document).ready(function () {
//     jQuery('form.productForm').on('submit', function (e) {
//         e.preventDefault();

//         var productname = jQuery('#productName').val().trim();
//         var price = jQuery('#price').val();
//         var sellprice = jQuery('#sellprice').val();
//         var stock = jQuery('#stock').val();
//         var description = jQuery('#description').val().trim();
//         // var image = jQuery('#image')[0].files[0];
//         var image = $('#image').val();
//         console.log(image);

//         if (!productname || !price || !stock || !description || !image) {
//             alert('Please fill all the fields and select an image.');
//             return;
//         }

//         var formData = new FormData();
//         formData.append('action', 'addproducts');
//         formData.append('productname', productname);
//         formData.append('price', price);
//         formData.append('stock', stock);
//         formData.append('description', description);
//         formData.append('image', image);
//         formData.append('sellprice', sellprice);

//         jQuery('input[name="categories[]"]:checked').each(function () {
//             formData.append('categories[]', jQuery(this).val());
//         });

//         // jQuery.ajax({
//         //     url: my_ajax_object.ajax_url,
//         //     type: "POST",
//         //     dataType: 'json',
//         //     processData: false,
//         //     contentType: false,
//         //     data: formData,
//         //     success: function (response) {
//         //         console.log(response);
//         //         if (response.data) {
//         //             window.location.href = response.data.redirect;
//         //         }
//         //     }
//         // });
//     });

// function open_custom_media_uploader() {
//     var custom_uploader = wp.media({
//         title: 'Insert a media',
//         library: { type: 'image' },
//         button: { text: 'Use this file' },
//         multiple: false
//     });

//     custom_uploader.on('select', function () {
//         var attachment = custom_uploader.state().get('selection').first().toJSON();
//         console.log(attachment);
//         $('#image').val(attachment.id);
//     });
//     custom_uploader.open();
// }

// $('#custom_file_upload').on('click', function (e) {
//     e.preventDefault();
//     open_custom_media_uploader();
// });
// });



// ==========================================================================================



// this is a ajax_delete_product ajax call here
// jQuery(document).ready(function () {
//     jQuery('.delete-product').on('click', function (e) {
//         e.preventDefault();

//         var productId = this.getAttribute('data-id');

//         jQuery.ajax({
//             url: my_ajax_object.ajax_url,
//             type: "POST",
//             dataType: 'json',
//             data: {
//                 'action': 'delete_product',
//                 'productid': productId
//             },
//             success: function (response) {
//                 console.log(response);
//                 alert(response.status)
//             }
//         });
//     });
// });



// ==========================================================================================



// this is a ajax_editproducts ajax call here
// jQuery(document).ready(function () {
//     jQuery('#editForm').on('submit', function (e) {
//         e.preventDefault();

// var productname = jQuery('#productName').val().trim();
// var price = jQuery('#price').val();
// var sellprice = jQuery('#sellprice').val();
// var id = jQuery('#id').val();
// var stock = jQuery('#stock').val();
// // var image = jQuery('#image')[0].files[0];
// var image = $('#editimage').val();
// console.log(image);
// let productid = jQuery('#hiddenid').val()

// var formData = new FormData();
// formData.append('action', 'editproducts');
// formData.append('productname', productname);
// formData.append('price', price);
// formData.append('stock', stock);
// formData.append('id', id);
// formData.append('image', image);
// formData.append('sellprice', sellprice);
// formData.append('productid', productid);

// jQuery('input[name="categories[]"]:checked').each(function () {
//     formData.append('categories[]', jQuery(this).val());
// });

//         jQuery.ajax({
//             type: 'POST',
//             url: my_ajax_object.ajax_url,
//             processData: false,
//             contentType: false,
//             data: formData,
//             dataType: 'json',
//             success: function (response) {
//                 if (response.success) {
//                     window.location.href = response.data.redirect;
//                 }
//             },
//         });
//     });

// function open_custom_media_uploader() {
//     var custom_uploader = wp.media({
//         title: 'Insert a media',
//         library: { type: 'image' },
//         button: { text: 'Use this file' },
//         multiple: false
//     });

//     custom_uploader.on('select', function () {
//         var attachment = custom_uploader.state().get('selection').first().toJSON();
//         console.log(attachment);
//         $('#editimage').val(attachment.id);
//     });
//     custom_uploader.open();
// }

// $('#custom_edit_file_upload').on('click', function (e) {
//     e.preventDefault();
//     open_custom_media_uploader();
// });
// });



// ==========================================================================================



// this is a not a ajax call simple btn click to some change
jQuery(document).ready(function () {
    jQuery(".remove").click(function () {

        var productId = jQuery(this).data("product-id");
        jQuery('#hiddenid').val(productId);

        this.setAttribute('data-product-id', '');
        var removeDiv = document.getElementById('remove');
        removeDiv.innerHTML = '';
    });
});



// ==========================================================================================



// this is a custom api for products show in frontend side 
// jQuery(document).ready(function ($) {
//     const apiEndpoint = 'http://localhost/wordpress/wp-json/cr/v1/products';
//     const productsContainer = $('.cards-container');

//     async function fetchProducts(page = 1, perPage = 6) {
//         try {
//             const response = await fetch(`${apiEndpoint}?page=${page}&per_page=${perPage}`);
//             const data = await response.json();

//             if (data.status === 'OK') {
//                 displayProducts(data.products);
//                 setupPagination(data.page, data.total_pages);
//             } else {
//                 productsContainer.html('<p>Failed to load products.</p>');
//             }
//         } catch (error) {
//             console.error('Error fetching products:', error);
//             productsContainer.html('<p>Error loading products.</p>');
//         }
//     }

//     // display products in html side
//     function displayProducts(products) {
//         productsContainer.empty();

//         products.forEach(product => {
//             const productElement = `
//                 <div class="card" ${product.stock == 0 ? 'style="opacity: 0.5; pointer-events: none;"' : ''}>
//                     <div class="image">
//                         <img src="${product.image}" alt="${product.title}">
//                     </div>

//                     ${product.sale_price ? `<p class="sale-price">Sale Price: ₹${parseFloat(product.sale_price).toLocaleString()}</p>` : ''}

//                     ${product.price ? `<p class="product-price">Price: ₹${parseFloat(product.price).toLocaleString()}</p>` : ''}

//                     ${product.stock == 0 ? '<p class="outstock">Out of Stock</p>' : ''}

//                     <div class="content">
//                         <a href="${product.permalink}">
//                             <span class="title">${product.title}</span>
//                         </a>
//                         <div id="category">
//                             ${product.categories.map(category => `<h3>${category.name}</h3>`).join('')}
//                         </div>
//                     </div>
//                 </div>
//             `;
//             productsContainer.append(productElement);
//         });
//     }

//     // display paginations in html side
//     function setupPagination(currentPage, totalPages) {
//         const paginationContainer = $('.pagination-container');
//         paginationContainer.empty();

//         let output = '<div class="custom-pagination"><ul class="pagination">';

//         if (currentPage > 1) {
//             const prevPage = currentPage - 1;
//             output += `<li><a href="#" data-page="${prevPage}">&laquo; Previous</a></li>`;
//         }

//         for (let i = 1; i <= totalPages; i++) {
//             if (i === currentPage) {
//                 output += `<li class="active disabled"><a href="#" data-page="${i}">${i}</a></li>`;
//             } else {
//                 output += `<li><a href="#" data-page="${i}">${i}</a></li>`;
//             }
//         }

//         if (currentPage < totalPages) {
//             const nextPage = currentPage + 1;
//             output += `<li><a href="#" data-page="${nextPage}">Next &raquo;</a></li>`;
//         }
//         output += '</ul></div>';
//         paginationContainer.html(output);

//         paginationContainer.find('a').on('click', function (e) {
//             e.preventDefault();
//             const page = $(this).data('page');
//             fetchProducts(page);
//         });
//     }
//     fetchProducts();
// });



// ==========================================================================================



// this is a custom api for products list show 
jQuery(document).ready(function ($) {
    const apiEndpoint = 'http://localhost/wordpress/wp-json/cr/v1/products'
    const productsContainer = $('.product-list-container');
    const paginationContainer = $('.list-pagination');

    async function fetchProductslist(page = 1, perpage = 6) {
        try {
            const response = await fetch(`${apiEndpoint}?page=${page}&per_page=${perpage}`);
            const data = await response.json();
            console.log(data);

            if (data.status === 'OK') {
                displayproductslist(data.products);
                setupPagination(page, data.total_pages);
            } else {
                productsContainer.html('<p>Something went wrong</p>');
            }
        } catch (error) {
            console.log(error);
        }
    }

    function displayproductslist(products) {
        productsContainer.empty();
        let elementlist = `
            <table border="1">
            <thead><tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Product Price</th>
            <th>Stock</th>
            <th>Sell Price</th>
            <th>Categories</th>
            <th>Action</th>
            <th>Action</th>
            </tr></thead><tbody>`;

        products.forEach(product => {
            elementlist += `<tr>
                <td>${product.id}</td>
                <td>${product.title}</td>
                <td>${product.price}</td>
                <td>${product.stock}</td>
                <td>${product.sale_price}</td>
                <td>${product.categories.map(category => category.name).join(', ')}</td>
                <td><a href="http://localhost/wordpress/edit-products?id=${product.id}"  class="edit-product" data-id=${product.id}>Edit</a></td>
                <td><button class="delete-product" data-id=${product.id}>Delete</button></td>
                </tr>`;
        });

        elementlist += `</tbody></table>`;
        productsContainer.append(elementlist);
    }

    function setupPagination(currentPage, totalPages) {
        paginationContainer.empty();

        let output = '<div class="custom-pagination"><ul class="pagination">';

        if (currentPage > 1) {
            const prevPage = currentPage - 1;
            output += `<li><a href="#" data-page="${prevPage}">&laquo; Previous</a></li>`;
        }

        for (let i = 1; i <= totalPages; i++) {
            if (i === currentPage) {
                output += `<li class="active disabled"><a href="#" data-page="${i}">${i}</a></li>`;
            } else {
                output += `<li><a href="#" data-page="${i}">${i}</a></li>`;
            }
        }

        if (currentPage < totalPages) {
            const nextPage = currentPage + 1;
            output += `<li><a href="#" data-page="${nextPage}">Next &raquo;</a></li>`;
        }

        output += '</ul></div>';
        paginationContainer.html(output);

        paginationContainer.find('a').on('click', function (e) {
            e.preventDefault();
            const page = $(this).data('page');
            fetchProductslist(page);
        });
    }

    fetchProductslist();
});



// ==========================================================================================



// this is a custom edit api for products edit and update and store 
// jQuery(document).on(function ($) {
//     const editproductapi = $('#editproductapi');

//     editproductapi.on('click', async function (e) {
//         e.preventDefault();

// var productname = jQuery('#productName').val().trim();
// var price = jQuery('#price').val();
// var sellprice = jQuery('#sellprice').val();
// var id = jQuery('#id').val();
// var stock = jQuery('#stock').val();
// var image = $('#editimage').val();

//         const productData = {};

//         productData.id = parseInt(id);
//         productData.title = productname;
//         productData.price = parseFloat(price);
//         productData.stock = parseInt(stock);
//         productData.sale_price = parseFloat(sellprice);
//         productData.image = image;
//         productData.categories = jQuery('input[name="categories[]"]:checked').map(function () {
//             return this.value;
//         }).get().join(',');

//         console.log(productData);

//         try {
//             const response = await fetch('http://localhost/wordpress/wp-json/cr/v1/product/' + productData.id, {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/json',
//                 },
//                 body: JSON.stringify(productData),
//             });

//             const data = await response.json();
//             if (response.ok) {
//                 console.log(data);
//                 window.location.href = 'http://localhost/wordpress/list-products/';
//             } else {
//                 alert('Error updating product');
//                 console.error(data);
//             }
//         } catch (error) {
//             console.error('Error:', error);
//         }
//     });

// function open_custom_media_uploader() {
//     var custom_uploader = wp.media({
//         title: 'Insert a media',
//         library: { type: 'image' },
//         button: { text: 'Use this file' },
//         multiple: false
//     });

//     custom_uploader.on('select', function () {
//         var attachment = custom_uploader.state().get('selection').first().toJSON();
//         $('#editimage').val(attachment.id);
//     });
//     custom_uploader.open();
// }

// jQuery(document).on('click', '#custom_edit_file_upload', function (e) {
//     e.preventDefault();
//     open_custom_media_uploader();
// });
// });





// ==========================================================================================



// this is a custom add api for products add and store with AUTH_TOKEN
jQuery(document).ready(function ($) {
    const addproductapi = $('#addproductapi');

    addproductapi.on('click', async function (e) {
        e.preventDefault();

        var productname = jQuery('#productName').val().trim();
        var price = jQuery('#price').val();
        var sellprice = jQuery('#sellprice').val();
        var stock = jQuery('#stock').val();
        var description = jQuery('#description').val().trim();
        var image = $('#image').val();

        if (!productname || !price || !stock || !description) {
            alert('Please fill all the fields.');
            return;
        }
        const productData = {};

        productData.title = productname;
        productData.description = description;
        productData.price = parseFloat(price);
        productData.stock = parseInt(stock);
        productData.sale_price = parseFloat(sellprice);
        productData.image = parseInt(image);

        productData.categories = jQuery('input[name="categories[]"]:checked').map(function () {
            return this.value;
        }).get().join(',');

        console.log(productData);
        try {
            var auth_token = document.cookie.split('; ').find(row => row.startsWith('auth_token')).split
                ('=')[1];
            console.log(auth_token);
            const response = await fetch('http://localhost/wordpress/wp-json/cr/v1/product/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + auth_token
                },
                body: JSON.stringify(productData),
            });

            const data = await response.json();
            if (response.ok) {
                console.log(data);
                window.location.href = 'http://localhost/wordpress/list-products/';
            } else {
                alert('Error updating product');
                console.error(data);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });


    function open_custom_media_uploader() {
        var custom_uploader = wp.media({
            title: 'Insert a media',
            library: { type: 'image' },
            button: { text: 'Use this file' },
            multiple: false
        });

        custom_uploader.on('select', function () {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#image').val(attachment.id);
        });
        custom_uploader.open();
    }


    $('#custom_file_upload').on('click', function (e) {
        e.preventDefault();
        open_custom_media_uploader();
    });
});



// =========================================================================================



// this is a custom delete api for products delete with AUTH_TOKEN
jQuery(document).on('click', '.delete-product', async function () {

    var id = this.getAttribute('data-id');
    console.log(id);

    // get the auth_token in cookies
    var auth_token = document.cookie.split('; ').find(row => row.startsWith('auth_token')).split
        ('=')[1];
    console.log(auth_token);


    try {
        const response = await fetch('http://localhost/wordpress/wp-json/cr/v1/product/delete/' + id,
            {
                method: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + auth_token
                }
            });
        console.log(response);
        if (response.ok) {
            console.log('Post deleted successfully!');
            location.reload();
        } else {
            throw new Error('Error deleting post: ' + response.statusText);
        }
    } catch (error) {
        console.error('Error deleting post:', error);
    }
});



// =========================================================================================



// this is a get one products rest api with AUTH_TOKEN
jQuery(document).ready(function ($) {
    const one_product = jQuery('.get_one_product');

    const urlParams = new URLSearchParams(window.location.search);
    const pid = urlParams.get('id');
    if (pid) {
        fetchProduct(pid);
    }


    async function fetchProduct(id) {
        var auth_token = document.cookie.split('; ').find(row => row.startsWith('auth_token')).split
            ('=')[1];
        console.log(auth_token);
        const response = await fetch('http://localhost/wordpress/wp-json/cr/v1/product/' + id,
            {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + auth_token
                }
            });
        const data = await response.json();
        // console.log(data);
        if (data) {
            console.log(data);
        } else {
            one_product.html('<p>Something went wrong</p>');
        }

        jQuery('#productName').val(data.title)
        jQuery('#price').val(data.price);
        jQuery('#sellprice').val(data.sale_price);
        jQuery('#id').val(data.id);
        jQuery('#stock').val(data.stock);
        jQuery('#showimage').attr('src', data.image);

        var category_names = [];
        jQuery.each(data.categories, function (index, category) {
            category_names.push(category.name);
        });
        var category_string = category_names.join(', ');

        jQuery('input[name="categories[]"]').each(function () {
            const value = this.value;
            if (category_string.includes(value)) {
                this.checked = true;
            }
        });
    }
});



// =========================================================================================



// this is a custom edit api for products edit with AUTH_TOKEN
const editProductApi = async (productData) => {
    try {
        var auth_token = document.cookie.split('; ').find(row => row.startsWith('auth_token')).split
            ('=')[1];
        console.log(auth_token);
        const response = await fetch('http://localhost/wordpress/wp-json/cr/v1/product/' + productData.id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + auth_token
            },
            body: JSON.stringify(productData),
        });
        const data = await response.json();
        if (response.ok) {
            console.log(data);
            window.location.href = 'http://localhost/wordpress/list-products/';
        } else {
            alert('Error updating product');
            console.error(data);
        }
    } catch (error) {
        console.error('Error:', error);
    }


};



// =========================================================================================



// this is a custom edit fucntions for callbake products edit
jQuery(document).on('click', '#editproductapi', async function (e) {
    e.preventDefault();

    var productname = jQuery('#productName').val().trim();
    var price = jQuery('#price').val();
    var sellprice = jQuery('#sellprice').val();
    var id = jQuery('#id').val();
    var stock = jQuery('#stock').val();
    var image = $('#editimage').val();
    const productData = {};

    productData.id = parseInt(id);
    productData.title = productname;
    productData.price = parseFloat(price);
    productData.stock = parseInt(stock);
    productData.sale_price = parseFloat(sellprice);
    productData.image = image;

    productData.categories = jQuery('input[name="categories[]"]:checked').map(function () {
        return this.value;
    }).get().join(',');

    console.log(productData);
    editProductApi(productData);
});



// =========================================================================================



// this is a media uploader open when click open
function open_custom_media_uploader() {
    var custom_uploader = wp.media({
        title: 'Insert a media',
        library: { type: 'image' },
        button: { text: 'Use this file' },
        multiple: false
    });

    custom_uploader.on('select', function () {
        var attachment = custom_uploader.state().get('selection').first().toJSON();
        $('#editimage').val(attachment.id);
    });
    custom_uploader.open();
}
jQuery(document).on('click', '#custom_edit_file_upload', function (e) {
    e.preventDefault();
    open_custom_media_uploader();
});



// =========================================================================================



// here a login rest api with create AUTH_TOKEN
jQuery(document).ready(function ($) {
    jQuery('form.ajax_login_form').on('submit', function (e) {
        e.preventDefault();
        var username = jQuery('#username').val().trim();
        var password = jQuery('#password').val().trim();
        jQuery.ajax({
            url: 'http://localhost/wordpress/wp-json/jwt-auth/v1/token',
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify({
                'username': username,
                'password': password
            }),
            contentType: 'application/json',
            success: function (response) {
                console.log(response.token);
                if (response) {
                    var expires = "";
                    var days = 7;
                    document.cookie = "auth_token=" + (response.token || "") + expires + "; path=/";
                    // window.location.href = response.data.redirect;
                }
            }
        });
    });
});
