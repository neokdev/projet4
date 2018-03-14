let $collectionHolder;

let $addTicketLink = $('<a role="button" href="#" class="add_ticket_link btn btn-primary">Add</a>');
let $newLinkLi = $('<li class="list-group list-group-flush"></li>').append($addTicketLink);

// Add translations for the buttons
let addTicketTrans = translations.addTicket;
let removeTicketTrans = translations.removeTicket;

$(function() {
    $collectionHolder = $('ul.tickets');

    $collectionHolder.append($newLinkLi);

    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addTicketLink.on('click', function(e) {
        e.preventDefault();

        addTicketForm($collectionHolder, $newLinkLi);
    });

    let ticketCollection = $('.list-group-item');

    addTicketFormDeleteLink(ticketCollection);

    $('.remove_ticket_link').on('click', function(e) {
        e.preventDefault();
        $(this).parent().remove();
    });

    $('.add_ticket_link').html(addTicketTrans);
    $('.remove_ticket_link').html(removeTicketTrans);
});

function addTicketForm($collectionHolder, $newLinkLi) {
    let prototype = $collectionHolder.data('prototype');

    let index = $collectionHolder.data('index');

    let newForm = prototype.replace(/__name__/g, index);

    $collectionHolder.data('index', index + 1);

    let $newFormLi = $('<li class="list-group-item"></li>');
    $newFormLi.append(newForm);
    $newLinkLi.before($newFormLi);

    $('.add_ticket_link').html(addTicketTrans);

    addTicketFormDeleteLink($newFormLi);
}

function addTicketFormDeleteLink($ticketFormLi) {
    let $removeFormA = $('<a role="button" href="#" class="remove_ticket_link btn btn-danger">Delete</a>');
    $ticketFormLi.append($removeFormA);

    $('.remove_ticket_link').html(removeTicketTrans);

    $removeFormA.on('click', function(e) {
        e.preventDefault();

        $(this).parent().remove();
    });
}