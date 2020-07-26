$(document).ready(function () {
  $('.js-vote-arrows').find('a').on('click', function (e) {

    var me = $(this);
    e.preventDefault();

    if (me.data('requestRunning')) {
      return;
    }

    me.data('requestRunning', true);

    e.preventDefault()
    var $link = $(e.currentTarget)
    $.ajax({
      url: '/recipe/recipeVote/' + $link.data('recipe') + '/vote/' + $link.data('direction'),
      method: 'POST',
    }).then(function (response) {
      $('.js-vote-arrows').find('.js-vote-total').text(response.vote);
      me.data('requestRunning', false);
    })

  })

  $('.js-fav-arrows').find('a').on('click', function (e) {
    var me = $(this);
    e.preventDefault();
    if (me.data('requestRunning')) {
      return;
    }

    me.data('requestRunning', true);

    var $link = $(e.currentTarget)
    $.ajax({
      url: '/recipe/recipeFav/' + $link.data('recipe'),
      method: 'POST',
    }).then(function (reponse) {
      if (reponse.fav != 'TRUE') {
        $('#heart').addClass('fa-heart')
        $('#heart').removeClass('fa-heart-o')
      } else {
        $('#heart').removeClass('fa-heart')
        $('#heart').addClass('fa-heart-o')
      }
      me.data('requestRunning', false);
    })
  })

  $('.comment').find('button').on('click', function (e) {
   
    var me = $(this);
    e.preventDefault();
    if (me.data('requestRunning')) {
      return;
    }

    me.data('requestRunning', true);
    var $link = $(e.currentTarget)
    $id = $link.data('comment')
    $.ajax({
      url: '/recipe/comment/remove/' + $link.data('comment'),
      method: 'POST',
    }).then(function (data) {
      document.getElementById("comment-"+$id).setAttribute("style","block-size:0;visibility:hidden");
      me.data('requestRunning', false);
    })
  })
})
