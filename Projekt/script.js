document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('todo-form');
    const taskInput = document.getElementById('task');

    form.addEventListener('submit', function(event) {
        if (taskInput.value.trim() === '') {
            event.preventDefault();
            alert('Task cannot be empty!');
        }
    });

    const listForm = document.getElementById('list-form');
    const listInput = document.getElementById('listInput');

    listForm.addEventListener('submit', function(event) {
        if (listInput.value.trim() === '') {
            event.preventDefault();
            alert('List cannot be empty!');
        }
    });
});
