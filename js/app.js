+(function ($) {
    $(document).on('click', '.sulli--searchBtn', function (e) {
        e.preventDefault();
        let $body = $('body');
        if ($body.hasClass('is-searchActive')) {
            $body.removeClass('is-searchActive');
        } else {
            $body.addClass('is-searchActive');
            $('.search-field').focus();
        }
    });

    let __list = 'sulliComment--list'; //your comment wrapprer
    $(document).on('submit', '#commentform', function () {
        $.ajax({
            url: SULLI.ajax_url,
            data: $(this).serialize() + '&action=ajax_comment',
            type: $(this).attr('method'),
            beforeSend: faAjax.createButterbar('提交中....'),
            error(request) {
                var t = faAjax;
                t.createButterbar(request.responseText);
            },
            success(data) {
                $('textarea').each(function () {
                    this.value = '';
                });
                let t = faAjax,
                    cancel = document.getElementById('cancel-comment-reply-link'),
                    temp = document.getElementById('wp-temp-form-div'),
                    respond = document.getElementById(t.respondId),
                    parent = document.getElementById('comment_parent').value;
                if (parent != '0') {
                    $('#respond').before('<ol class="children">' + data + '</ol>');
                } else if (!$('.' + __list).length) {
                    if (SULLI.formpostion == 'bottom') {
                        $('#respond').before('<ol class="' + __list + '">' + data + '</ol>');
                    } else {
                        $('#respond').after('<ol class="' + __list + '">' + data + '</ol>');
                    }
                } else {
                    if (SULLI.order == 'asc') {
                        $('.' + __list).append(data); // your comments wrapper
                    } else {
                        $('.' + __list).prepend(data); // your comments wrapper
                    }
                }
                t.createButterbar('提交成功');
                cancel.style.display = 'none';
                cancel.onclick = null;
                document.getElementById('comment_parent').value = '0';
                if (temp && respond) {
                    temp.parentNode.insertBefore(respond, temp);
                    temp.parentNode.removeChild(temp);
                }
            },
        });
        return false;
    });
    let faAjax = {
        I(e) {
            return document.getElementById(e);
        },
        clearButterbar() {
            if ($('.butterBar').length > 0) {
                $('.butterBar').remove();
            }
        },
        createButterbar(message) {
            const t = this;
            t.clearButterbar();
            $('body').append(
                '<div class="butterBar butterBar--center"><p class="butterBar-message">' +
                    message +
                    '</p></div>'
            );
            setTimeout("$('.butterBar').remove()", 3000);
        },
    };
})(jQuery);
