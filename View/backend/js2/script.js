function toggleUpdateForm(categoryId) {
    const form = document.getElementById(`update-form-${categoryId}`);
    form.style.display = form.style.display === 'none' || form.style.display === '' ? 'block' : 'none';}
    
    
function add(event) {
    const txt = document.getElementById("add1").value;
    const txt2 = document.getElementById("add2").value;

    if (!isNaN(txt) || !isNaN(txt2)) {
    alert("Category Name doit contenir uniquement des caractères alphabétiques !");
    event.preventDefault(); 
    }
}