// setup an "add a ticket" link
let $addticketLink = $('<a role="button" href="#" id="add" class="add_ticket_link btn btn-primary">prout</a>');
let $newLinkLi = $('<li class="list-group list-group-flush"></li>').append($addticketLink);

// Add translations for the buttons
let addTicketTrans = translations.addticket;
let removeTicketTrans = translations.removeticket;

$(function() {
    // Get the ul that holds the collection of tickets
    let $collectionHolder = $('ul.tickets');

    // add the "add a ticket" anchor and li to the tickets ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);


    // $("#add").html(addTicketTrans);

    $addticketLink.on('click', (e) => {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new ticket form (see code block below)
        addticketForm($collectionHolder, $newLinkLi);

        // Add the translation for the remove button
        $(".remove-ticket").html(removeTicketTrans);
    });

    // Add the translation for the add button
    $(".add_ticket_link").html(addTicketTrans);

});

function addticketForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    let prototype = $collectionHolder.data('prototype');

    // get the new index
    let index = $collectionHolder.data('index');

    // Replace '$$name$$' in the prototype's HTML to
    // instead be a number based on how many items we have
    let newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a ticket" link li
    let $newFormLi = $('<li class="list-group list-group-flush"></li>').append(newForm);

    // also add a remove button, just for this example
    $newFormLi.append('<a role="button" href="#" class="remove-ticket btn btn-danger">removeTicketTranslation</a>');

    $newLinkLi.before($newFormLi);

    // handle the removal, just for this example
    $('.remove-ticket').click(function(e) {
        e.preventDefault();

        $(this).parent().remove();

        return false;
    });
}