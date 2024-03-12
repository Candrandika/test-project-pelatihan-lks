<template>
  <div class="container">
    <div class="row my-3">
      <div class="col-md-4 col-12">
        <div class="form-group">
          <h5>Type</h5>
          <span class="badge bg-primary" v-if="(form.type = 'public')"
            >Public</span
          >
          <span class="badge bg-info" v-else>Private</span>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="form-group">
          <h5>Expired</h5>
          {{ form.expired }}
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="form-group">
          <h5>Allowed Domain</h5>
          {{ form.domains.join(",") }}
        </div>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-12">
        <div class="form-group">
          <h3>Question</h3>
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
              <tr v-for="(question, index) in form.questions">
                <th>{{ index + 1 }}</th>
                <td>{{ question.question }}</td>
                <td>{{ question.type }}</td>
                <td>{{ question.is_required ? "✅" : "❌" }}</td>
                <td>
                  {{
                    question.options.length > 0
                      ? changeOptionToString(question.options)
                      : "-"
                  }}
                </td>
                <td>
                  <button
                    class="btn btn-sm btn-primary"
                    type="button"
                    data-bs-toggle="modal"
                    data-bs-target="#question-detail-modal"
                    @click="getDetailQuestion(question.id)"
                  >
                    Detail
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-12">
        <h3>Respondens</h3>
        <table class="table table-striped text-center align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(res, index) in form?.respondens">
              <th>{{ index + 1 }}</th>
              <td>{{ res.name }}</td>
              <td>{{ res.email }}</td>
              <td>
                <button
                  type="button"
                  class="btn btn-sm btn-primary"
                  data-bs-toggle="modal"
                  data-bs-target="#user-answer-modal"
                  @click="getDetailResponse(res.user_id, res.email)"
                >
                  Show Answer
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal" tabindex="-1" id="question-detail-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5>Question</h5>
          <button
            type="button"
            data-bs-dismiss="modal"
            class="btn-close"
          ></button>
        </div>
        <div class="modal-body">
          <table class="table text-center align-middle table-striped">
            <thead>
              <tr>
                <th>Respondens</th>
                <th>Answer</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(answer, email) in question.responses">
                <td>{{ email }}</td>
                <td>{{ answer }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="modal" tabindex="-1" id="user-answer-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5>User Answer</h5>
          <button
            type="button"
            data-bs-dismiss="modal"
            class="btn-close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="text-center mb-3">Response from {{ response.email }}</div>
          <table class="table text-center align-middle table-striped">
            <thead>
              <tr>
                <th>Question</th>
                <th>Answer</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(a, q) in response.responses">
                <td>{{ q }}</td>
                <td>{{ typeof(a) == 'object' ? a.join(', ') : a }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  emits: ['updateUser'],
  props: ["form"],
  data() {
    return {
      question: {
        question: {},
        responses: {}
      },
      response: {
        responses: {},
        email: ''
      }
    };
  },
  mounted() {
    console.log(this.form)
  },
  methods: {
    changeOptionToString(options) {
      const array_option = [];
      options.map((option) => {
        array_option.push(option.option);
      });

      return array_option.join(", ");
    },
    getDetailQuestion(id) {
      axios.get(import.meta.env.VITE_BASE_API_URL+'/questions/'+id+"?token="+this.$getToken())
        .then(res => {
          this.question = res.data
        }).catch(err => {
          alert(err.response.data.message)
        })
    },
    getDetailResponse(user_id, user_email) {
      this.response.email = user_email
      axios.get(import.meta.env.VITE_BASE_API_URL+`/response?token=${this.$getToken()}&user_id=${user_id}&form_id=${this.form.id}`)
        .then(res => {
          this.response.responses = res.data.responses
        }).catch(err => {
          alert(err.response.data.message)
        })
    }
  },
};
</script>
