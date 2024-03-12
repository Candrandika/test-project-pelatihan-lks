<template>
  <div class="container">
    <form action="" @submit.prevent="createForm">
      <section id="form-detail">
        <div class="row mb-3">
          <div class="col-6">
            <label for="name">Form Name</label>
            <input
              type="text"
              class="form-control"
              placeholder="Name or Title of your form"
              v-model="form.name"
              id="name"
            />
          </div>
          <div class="col-6">
            <label for="expired">Form Expired</label>
            <input type="date" class="form-control" v-model="form.expired" id="expired"/>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-12">
            <label for="description">Form Description</label>
            <textarea
              class="form-control"
              placeholder="Description of your form"
              v-model="form.description"
              id="description"
            ></textarea>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-12">
            <label for="type">Form Type</label>
            <select class="form-select" v-model="form.type" id="type">
              <option value="" selected disabled>
                -- select option type --
              </option>
              <option value="public">Public</option>
              <option value="private">Private</option>
            </select>
          </div>
          <div class="col-12 mt-3" v-if="form.type == 'private'">
            <div class="d-flex justify-content-between align-items-center">
              <div>Domain</div>
              <button
                type="button"
                @click="addNewDomain"
                class="btn btn-sm btn-primary"
              >
                + add domain
              </button>
            </div>
            <div class="mt-2">
              <div class="input-group mb-1" v-for="(domain, domainIndex) in form.domains" :key="domainIndex">
                <input type="text" class="form-control" placeholder="domain" v-model="form.domains[domainIndex]" :id="'domain'+domainIndex"/>
                <button type="button" class="btn btn-danger" @click="removeDomain(domainIndex)">&times;</button>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section id="question-list">
        <div class="mb-3 d-flex justify-content-between align-items-center">
          <h3>Question List</h3>
          <button
            type="button"
            class="btn btn-sm btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#question-modal"
          >
            + question
          </button>
        </div>
        <table class="table table-striped align-middle text-center">
          <thead>
            <tr>
              <th>#</th>
              <th>Question</th>
              <th>Type</th>
              <th>Is Required</th>
              <th>Option</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(question, questionIndex) in form.questions" :key="questionIndex">
              <th>{{ questionIndex+1 }}</th>
              <td>{{ question.question }}</td>
              <td>{{ question.type }}</td>
              <td>{{ question.is_required ? "✅" : "❌" }}</td>
              <td>{{ question.options ? question.options : "-" }}</td>
              <td>
                <button class="btn btn-sm btn-danger" type="button" @click="deleteQuestion(questionIndex)">
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </section>

      <button class="btn btn-primary mt-3">Create Form</button>
    </form>
  </div>

  <div class="modal" tabindex="-1" id="question-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5>Add New Question</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
          ></button>
        </div>
        <div class="modal-body">
          <div class="form-group mb-3">
            <label for="question-question">Question</label>
            <input type="text" class="form-control" placeholder="Question" v-model="question.question" id="question-question"/>
          </div>
          <div class="form-group mb-3">
            <label for="question-description">Description</label>
            <input type="text" class="form-control" placeholder="Description (showed as placeholder)" v-model="question.description" id="question-description"/>
          </div>
          <div class="form-group mb-3">
            <label for="question-type">Type</label>
            <select class="form-select" id="question-type" v-model="question.type">
              <option value="" disabled selected>
                -- select question type --
              </option>
              <option value="text">Text</option>
              <option value="number">Number</option>
              <option value="checkbox">Checkbox</option>
              <option value="select">Select</option>
              <option value="textarea">Textarea</option>
            </select>
          </div>
          <div class="form-group mb-3" v-if="question.type == 'checkbox' || question.type == 'select'">
            <label for="question-options">Option</label>
            <input
              type="text"
              placeholder="Separate the option by comma (,)"
              class="form-control"
              v-model="question.options"
            />
          </div>
          <div class="form-group mb-3">
            <input type="checkbox" class="form-checkbox me-2" v-model="question.is_required" id="question-required"/>
            <label for="question-required">is required</label>
          </div>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            Close
          </button>
          <button type="button" class="btn btn-primary" @click="addNewQuestion">+ submit</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  emits: ['updateUser'],
  data() {
    return {
      form: {
        name: "",
        description: "",
        type: "",
        domains: [],
        expired: "",
        questions: [],
      },
      question: {
        question: "",
          description: "",
          type: "",
          is_required: false,
          options: ""
      }
    };
  },
  beforeCreate() {
      this.$emit('changePageTitle', 'Create New Form')
  },
  methods: {
    addNewDomain() {
      this.form.domains.push("")
    },
    removeDomain(domainIndex) {
      this.form.domains.splice(domainIndex, 1)
    },
    deleteQuestion(questionIndex) {
      this.form.questions.splice(questionIndex, 1)
    },
    addNewQuestion() {
      console.log(this.question)
      if(!this.question.question || !this.question.description || !this.question.type) alert("All fields can't be empty.")
      else if((this.question.type == 'checkbox' || this.question.type == 'select') && !this.question.options) alert("All fields can't be empty")
      else {
        const q = this.question;
        if(!(q.type == "checkbox" || q.type == "select")) q.options = ""
        this.form.questions.push(q)

        this.question = {
          question: "",
            description: "",
            type: "",
            is_required: false,
            options: ""
        }
      }
    },
    createForm() {
      axios.post(import.meta.env.VITE_BASE_API_URL+'/forms?token='+this.$getToken(), this.form)
        .then((res) => {
          alert(res.data.message)
          this.$router.push('/')
        }).catch((err) => {
          alert(err.response.data.message)
        })
    }
  }
};
</script>
