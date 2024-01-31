import './bootstrap';
window.livewire = Livewire;

import Swal from 'sweetalert2'; // Swal alert
import "blueimp-file-upload"; // Chunk Upload
import Sortable from 'sortablejs'; // Sortable
window.Sortable = Sortable;

import './components/app/modal'; // Modal
import './components/app/drawer'; // Drawer

if (typeof window.livewire === 'undefined') {
    throw 'Livewire Sortable Plugin: window.livewire is undefined. Make sure @livewireScripts is placed above this script include';
}

/*window.livewire.directive('sort', (el, directive, component) => {

    let options = {};

    if (el.hasAttribute('sort.options')) {
        var otherOptions = el.getAttribute('sort.options');
        var optionJson = otherOptions.replace(/(['"])?([a-z0-9A-Z_]+)(['"])?:/g, '"$2": ');

        try {
            options = JSON.parse(optionJson);
        } catch (e) {
            options = {};
        }
    }

    if (directive.modifiers.length > 0) return;

    const sortable = new Sortable(el, {
        group: options.group,
        draggable: '[sort\\.item]',
        handle: '[sort\\.handle]',
        ghostClass: 'sortable-ghost',
        fallbackOnBody: true,
        animation: 150,
        invertSwap: true,
        onSort: () => {
            let items = [];
            el.querySelectorAll('[sort\\.item="' + options.group + '"]').forEach((el, index) => {
                items.push({
                    order: index + 1,
                    id: el.getAttribute('sort.id'),
                    parent: el.getAttribute('sort.parent'),
                });
            });

            component.call(options.method, {
                owner: options.owner,
                group: options.group,
                items,
            });
        },
    });
});*/

jQuery('document').ready(function () {
    // Document click
    jQuery(document).on('click', '.password__btn-label',function (e) {
        let parent = jQuery(this).parent().parent(),
            password = parent.find('.password__input');
        if (password.attr('type') === "password") {
            password.attr('type', 'text');
            parent.find('.show-password').removeClass('hidden');
            parent.find('.hidden-password').addClass('hidden');
        } else {
            password.attr('type', 'password');
            parent.find('.show-password').addClass('hidden');
            parent.find('.hidden-password').removeClass('hidden');
        }
        e.preventDefault();

    });

    // Reload page
    window.addEventListener('reload_page', function(event){
        location.reload();
    });

    // Close Drawer
    window.addEventListener('close-drawer', function(event){
        jQuery('.drawer').find('.js-drawer__close').click();
    });

    // Open modal function
    function openModal(element) {
        var event = new CustomEvent('openModal');
        element.dispatchEvent(event);
    };

    // Image modal
    let modalImg = jQuery("#modal-image");
    jQuery(document).on("click",".modal-img-btn", function(e){
        let $this = jQuery(this);
        if(modalImg.length > 0) {
            modalImg.find("img").attr('src',$this.find('img').attr('data-src'));
            openModal(modalImg[0])
        }
        e.preventDefault();
    });
    // Open Modal
    window.addEventListener('open_modal', function(event){
        let modal = jQuery("#" + event.detail.modal)[0];
        openModal(modal);
    });

    // Open Modal
    window.addEventListener('open_modal', function (event) {
        let modal = document.getElementById(event.detail.modal);
        if (modal) {
            openModal(modal);
        }
    });

    // Form submit : disable buttons
    jQuery(document).on('submit', 'form', function (e) {
        var targetForm = jQuery(this);

        var formButtons = targetForm.find('.form-buttons button, .form-buttons a');
        if (formButtons.length > 0) {
            formButtons.each(function () {
                var button = $(this);
                button.prop('disabled', true);

                var loadingSpinner = button.find('.loading-spinner');
                if (loadingSpinner.length) {
                    loadingSpinner.removeAttr('wire:loading');
                    loadingSpinner.removeAttr('wire:target');
                }

                var blockSpan = button.find('span.block');
                if (blockSpan.length) {
                    blockSpan.addClass('hidden');
                }
            });
        }
    });
    // Delete confirmation
    jQuery(document).on('click', 'a.delete-link', function(e) {
        var link = jQuery(this),
            href = link.getAttribute('href');

        Swal.fire({
            title: link.getAttribute('data-title'),
            text: link.getAttribute('data-description'),
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Non',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = href;
            }
        });
        e.preventDefault();
        e.stopPropagation();
    });

    // Chunk Upload
    jQuery(document).find(".fileupload").each(function(){
        var $uploadList = jQuery(this).parent().parent().find(".file-upload-list");
        var $fileUpload = jQuery(this);
        if ($uploadList.length > 0 && $fileUpload.length > 0) {
            var idSequence = 0;
            $fileUpload.fileupload({
                maxChunkSize: 5000000,
                method: "POST",
                sequentialUploads: true,
                formData: function (form) {
                    return [{name: '_token', value: document.head.querySelector('meta[name="csrf-token"]').getAttribute("content")}];
                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    jQuery("#" + data.theId).find('.progress-percent').empty().text(progress + '%');
                    jQuery("#" + data.theId).find('.file-progress').css({ width: progress + '%' });
                },
                add: function (e, data) {
                    console.log(data);
                    data._progress.theId = 'id_' + idSequence;
                    idSequence++;
                    var $fileDiv = '<div class="relative bg-gray-200 w-full h-4 mb-2">';
                    $fileDiv += '<div class="bg-info absolute top-0 left-0 h-4 file-progress" style="width:0%"></div>';
                    $fileDiv += '</div>';
                    $fileDiv += '<div class="flex flex-wrap gap-2 text-sm">';
                    $fileDiv += '<span>'+data.files[0].name+' : </span>';
                    $fileDiv += '<strong class="progress-percent">0%</strong>';
                    $fileDiv += '</div>';
                    $uploadList.append($('<li id="' + data.theId + '" class="list-group-item my-4 p-2 border">'+$fileDiv+'</li>'));
                    data.submit();
                },
                done: function (e, data) {
                    jQuery("#" + data.theId).find('.progress-percent').empty().text('Upload terminé, vous pouvez enregistrer').addClass('text-success');
                    jQuery("#" + data.theId).find('.file-progress').empty().removeClass('bg-info').addClass('bg-success');
                    //$uploadList.append($('<li class="flex items-center justify-between gap-2 w-full p-3 text-sm bg-white border rounded shadow-sm sort-item-element mt-2"></li>').text('Terminé: ' + data.result.file_name+". N'oubliez pas d'enregistrer"));
                    var $input = jQuery('input[name="'+data.result.field+'"]'),
                        $val = $input.val(),
                        $array = new Array();
                    if($val) {
                        $array.push(JSON.parse($val));
                    }
                    $array.push(data.result.media);
                    $input.val(JSON.stringify($array));
                    window.livewire.emit('setChunkedFileUpload', $fileUpload.attr('data-file-name'), JSON.stringify($array));
                }
            });
        }
    });
    // Check all permissions checkboxes
    jQuery(".all-checkboxes").on('click', function(e){
        jQuery(this).parent().parent().find('input[type="checkbox"]').prop('checked', true);
        e.preventDefault();
    });
});
