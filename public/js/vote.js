$(document).ready(function () {
  var $vote = $('.js-vote-arrows')
  $vote.find('a').on('click', function (e) {
    e.preventDefault()
    var $link = $(e.currentTarget)
    $.ajax({
      url:
        '/recipe/recipeVote/' +
        $link.data('recipe') +
        '/vote/' +
        $link.data('direction'),
      method: 'POST',
    }).then(function (response) {
      $vote.find('.js-vote-total').text(response.vote)
    })
  })

  var $fav = $('.js-fav-arrows')
  $fav.find('a').on('click', function (e) {
    e.preventDefault()
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
    })
  })
})
