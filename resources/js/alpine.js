/*import "alpinejs";
import './base/base.js';*/

window.todoStore = {
    /*SQL MANIA --> what you want goes here*/
    todos: JSON.parse(localStorage.getItem('todo-store') || '[]'),

    save() {
        localStorage.setItem('todo-store', JSON.stringify(this.todos));
    },
};

window.todos = function () {
    /*SQL MANIA --> and can also go in here or alternate in here before the return
    which gives you the chance to feed in data here from sql/orm by getting it from an AJAX call before you return the whole alpine-whammy*/
    return {
        ...todoStore,
        filter: 'all',

        todos: [],

        get active() {
            return this.todos.filter(todo => !todo.completed)
        },

        get completed() {
            return this.todos.filter(todo => todo.completed)
        },

        get filteredTodos(){
            if(this.filter === 'all')
            {
                return this.todos;
            }
            if(this.filter === 'completed')
            {
                return this.completed;
            }
            if(this.filter === 'active')
            {
                return this.active;
            }
        },

        get allComplete(){
            return this.todos.length === this.completed.length;
        },
        newTodo: '',
        editedTodo: false,
        addTodo() {
            if(this.newTodo.trim() != '' && this.newTodo.length > 0){
                this.todos.push({
                    id: Date.now(),
                    body: this.newTodo,
                    completed: false
                });
                this.newTodo = '';
            }
        },
        enterTodo(todo) {
            if(todo.body.trim() === ''){
                this.deleteTodo(todo);
            }
            this.editedTodo = null;
        },
        deleteTodo(todo){
            let position = this.todos.indexOf(todo);
            this.todos.splice(position, 1);
        },
        completeTodo(todo){
            todo.completed = !todo.completed;
        },
        clearCompleted(){
            this.todos = this.todos.filter(todo => !todo.completed)
        },
        editTodo(todo){
            todo.cachedBody = todo.body;
            this.editedTodo = todo;
        },
        cancelEdit(todo)
        {
            todo.body = todo.cachedBody;
            delete todo.cachedBody;
            this.editedTodo = null;
        },
        toggleAllTodos(){
            let allComplete = this.allComplete;

            this.todos.forEach(todo => todo.completed = ! allComplete)
        },
    };
};
