<template>
  <div>
    <h3>My Books</h3>
    <form @submit.prevent="addBook" class="card card-body mb-3">
      <div class="form-row">
        <div class="form-group col-md-6">
          <input
            v-model="book.title"
            type="text"
            name="title"
            placeholder="Title"
            class="form-control"
            id
          />
        </div>
        <div class="form-group col-md-3">
          <input
            v-model="book.author"
            type="text"
            name="author"
            placeholder="Author"
            class="form-control"
            id
          />
        </div>
        <div class="form-group col-md-3">
          <input
            v-model="book.field"
            type="text"
            name="field"
            placeholder="Field"
            class="form-control"
            id
          />
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-12">
          <textarea
            v-model="book.description"
            class="form-control"
            id="exampleFormControlTextarea1"
            rows="3"
          >Description</textarea>
        </div>
      </div>
      <button type="submit" class="btn btn-light">Add Book</button>
    </form>

    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
          <a class="page-link" href="#" @click="fetchBooks(pagination.prev_page_url)">Previous</a>
        </li>
        <li class="page-item disabled">
          <a
            class="page-link text-dark"
            href="#"
          >Page {{ pagination.current_page }} of {{ pagination.last_page }}</a>
        </li>
        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
          <a class="page-link" href="#" @click="fetchBooks(pagination.next_page_url)">Next</a>
        </li>
      </ul>
    </nav>
    <div class="card card-body mb-2" v-for="book in books" v-bind:key="book.id">
      <h4>Title: {{ book.title }}</h4>
      <h5>Description: {{ book.description }}</h5>
      <h6>Author(s): {{ book.author }}</h6>
      <p>Field: {{ book.field }}</p>
      <hr />
      <button @click="editBook(book)" class="btn btn-warning mb-2">Edit</button>
      <button @click="deleteBook(book.id)" class="btn btn-danger">Delete</button>
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      books: [],
      book: {
        id: "",
        title: "",
        description: "",
        author: "",
        field: ""
      },
      book_id: "",
      pagination: {},
      edit: false
    };
  },
  created() {
    //fetchBooks() is custom defined
    this.fetchBooks();
  },
  methods: {
    fetchBooks(page_url) {
      let vm = this;
      page_url = page_url || "/api/books";
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.books = res.data;
          vm.makePagination(res.meta, res.links);
        })
        .catch(err => console.log(err));
    },
    makePagination(meta, links) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev
      };

      this.pagination = pagination;
    },
    deleteBook(id) {
      if (confirm("Are You Sure?")) {
        fetch(`api/book/${id}`, {
          method: "delete"
        })
          .then(res => res.json())
          .then(data => {
            alert("Book Removed");
            this.fetchBooks();
          })
          .catch(err => console.log(err));
      }
    },
    addBook() {
      if (this.edit === false) {
        // add a book
        fetch("api/book", {
          method: "post",
          body: JSON.stringify(this.book),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {
            this.book.title = "";
            this.book.description = "";
            this.book.author = "";
            this.book.field = "";
            alert("Book Added");
            this.fetchBooks();
          })
          .catch(err => console.log(err));
      } else {
        // update book
        fetch("api/book", {
          method: "put",
          body: JSON.stringify(this.book),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {
            this.book.title = "";
            this.book.description = "";
            this.book.author = "";
            this.book.field = "";
            alert("Book Updated");
            this.fetchBooks();
          })
          .catch(err => console.log(err));
      }
    },
    editBook(book) {
      this.edit = true;
      this.book.id = book.id;
      this.book.book_id = book.id;
      this.book.title = book.title;
      this.book.description = book.description;
      this.book.author = book.author;
      this.book.field = book.field;
    }
  }
};
</script>