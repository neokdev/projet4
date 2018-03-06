let $collectionHolder;

let $addTicketLink = $('<a role="button" href="#" class="add_ticket_link btn btn-primary">Add</a>');
let $newLinkLi = $('<li class="list-group list-group-flush"></li>').append($addTicketLink);

$(function() {
    $collectionHolder = $('ul.tickets');

    $collectionHolder.append($newLinkLi);

    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addTicketLink.on('click', function(e) {
        e.preventDefault();

        addTicketForm($collectionHolder, $newLinkLi);
    });
    ///////////////////////////////////////////////////////
    // TESTS
    ///////////////////////////////////////////////////////

    ticketCollection = $('.list-group-item');

    addTicketFormDeleteLink(ticketCollection);

    $('.remove_ticket_link').on('click', function(e) {
        e.preventDefault();
        $(this).parent().remove();
    });

});

function addTicketForm($collectionHolder, $newLinkLi) {
    let prototype = $collectionHolder.data('prototype');

    let index = $collectionHolder.data('index');

    let newForm = prototype.replace(/__name__/g, index);

    $collectionHolder.data('index', index + 1);

    let $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);

    addTicketFormDeleteLink($newFormLi);
}

function addTicketFormDeleteLink($ticketFormLi) {
    let $removeFormA = $('<a role="button" href="#" class="remove_ticket_link btn btn-danger">Delete</a>');
    $ticketFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        e.preventDefault();

        $(this).parent().remove();
    });
}