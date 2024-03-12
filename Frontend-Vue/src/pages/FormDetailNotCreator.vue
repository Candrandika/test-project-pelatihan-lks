<template>
    <div class="container">
        <div class="row my-3">
          <div class="col-md-4 col-12">
            <div class="form-group">
              <h5>Type</h5>
              <span class="badge bg-primary" v-if="form.type=='public'">Public</span>
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
              {{ form.domains.join(', ') }}
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <div class="form-group">
              <h3>Question</h3>
              <form @submit.prevent="submitResponse">

                <div class="form-group mb-3" v-for="(question, qIndex) in form?.questions" :key="qIndex" v-if="show_question">
                  <label
                    >{{ question.question }} <span v-if="question.is_required" class="text-danger">*</span></label
                  >
                  <textarea
                    class="form-control"
                    :placeholder="question.description"
                    v-model="response.responses[question.id]"
                    v-if="question.type=='textarea'"
                  ></textarea>
                  <select class="form-select" v-else-if="question.type=='select'" v-model="response.responses[question.id]">
                    <option v-for="(option, oIndex) in question.options" :value="option.option" :key="oIndex">{{ option.option }}</option>
                  </select>
                  <div v-else-if="question.type=='checkbox'">
                    <div v-for="(option, oIndex) in question.options" :key="oIndex">
                      <input type="checkbox" v-model="response.responses[question.id]" :value="option.option"> {{ option.option }}
                    </div>
                  </div>
                  <input
                    v-else
                    v-model="response.responses[question.id]"
                    :type="question.type"
                    :placeholder="question.description"
                    class="form-control"
                  />
                </div>
                <button class="btn btn-primary w-100" type="submit">Submit</button>
              </form>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
export default {
  props: ['form'],
  data() {
    return {
      response: {
        form_id: 0,
        responses: {}
      },
      show_question: false
    }
  },
  mounted() {
    this.$watch('form', function(newValue, oldValue) {
      this.updateResponseData()
    })
  },
  methods: {
    updateResponseData() {
      console.log(this.form)
      this.response.form_id = this.form.id;
      this.form.questions.map((question, index) => {
        this.response.responses[question.id] = ''
        if(question.type == 'checkbox') this.response.responses[question.id] = []
      })
      this.show_question = true
    },
    submitResponse() {
      let invalid_count = 0;

      this.form.questions.map((question) => {
        if(question.is_required) {
          if(!this.response.responses[question.id]) invalid_count++
        }
        if(question.type == 'checkbox') this.response.responses[question.id] = this.response.responses[question.id].join(',')
      })

      if(invalid_count > 0) {
        alert('field with * cannot be empty')
        this.setResponseBack()
        return
      }

      axios.post(import.meta.env.VITE_BASE_API_URL+'/response?token='+this.$getToken(), this.response)
        .then(res => {
          alert(res.data.message)
          this.$router.push('/form')
        }).catch(err => {
          alert(err.response.data.message)
          this.setResponseBack()
        })
    },
    setResponseBack() {
      this.form.questions.map((question) => {
        if(question.type == 'checkbox') this.response.responses[question.id] = this.response.responses[question.id].split(',')
      })
    }
  }
}
</script>