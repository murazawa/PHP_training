$(document).on('click', '.post_window', function() {
  //背景をスクロールできないように　&　スクロール場所を維持
  scroll_position = $(window).scrollTop();
  $('body').addClass('fixed').css({ 'top': -scroll_position });
  // モーダルウィンドウを開く
  $('.post_process').fadeIn();
  $('.modal').fadeIn();
});

$(document).on('click', '.edit_modal', function(){

  scroll_position = $(window).scrollTop();
  $('body').addClass('fixed').css({ 'top': -scroll_position });

  $('.update').fadeIn();
  $('.modal').fadeIn();
});
