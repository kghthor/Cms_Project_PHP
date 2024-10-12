function openModal() {
    document.getElementById('categoryModal').style.display = 'block';
    document.getElementById('modalTitle').textContent = 'Add Category';
    document.getElementById('categoryForm').reset();
    document.getElementById('categoryId').value = '';
}

function closeModal() {
    document.getElementById('categoryModal').style.display = 'none';
}

function editCategory(id, name) {
    document.getElementById('categoryModal').style.display = 'block';
    document.getElementById('modalTitle').textContent = 'Edit Category';
    document.getElementById('categoryId').value = id;
    document.getElementById('categoryName').value = name;
}