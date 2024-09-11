//lida com requisição para deletar contato
const handleSubmitDell = async (id) => {
    try {
        await fetch(`/pages/contacts.php?id=${id}`, {
            method: "DELETE",
        });
    } catch (error) {
        console.log("Erro: " + error);
    }
}

//mostra o modal para adição de contato
const handleModalView = () => {
    var inputOnModal = document.querySelectorAll("input.form-control");
    var modal = document.getElementById("modal-add");
    modal.style.display = modal.style.display == "none" 
        ? "block"
        : "none";
    inputOnModal.forEach(item => item.value = "");
}

//filtra contatos de acordo com input
const handleFilterContacts = (event) => {
    var listContacts = Array.from(document.querySelectorAll("tr.list"));
    var filteredList = listContacts.filter(item => item.querySelector("td>a")
        .textContent
        .toLowerCase()
        .includes(event.target.value.toLowerCase()));
    listContacts.forEach(item => item.style.display = "none");
    filteredList.forEach(item => item.style.display = "");
}

