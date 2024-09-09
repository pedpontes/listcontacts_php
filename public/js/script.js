const handleSubmitDell = async (id) => {
    try {
        await fetch(`/pages/contacts.php?id=${id}`, {
            method: "DELETE",
        });
    } catch (error) {
        console.log("Erro: " + error);
    }
}

const handleModalView = () => {
    var inputOnModal = document.querySelectorAll("input.form-control");
    var modal = document.getElementById("modal-add");
    modal.style.display = modal.style.display == "none" 
        ? "block"
        : "none";
    inputOnModal.forEach(item => item.value = "");
}