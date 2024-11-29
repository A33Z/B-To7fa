function validateForm(event) {
    const titre = document.getElementById('titre').value;
    const contenu = document.getElementById('contenu').value;

    if (/\d/.test(titre) || /\d/.test(contenu)) {
        alert("Please enter only alphabetic characters in Title and Content fields!");
        event.preventDefault();
        return false;
    }
    return true;
}