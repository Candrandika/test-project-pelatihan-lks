<template>
    <!-- S: My Response Section -->
    <section class="response-section mb-5">
        <div class="section-header mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="section-title text-muted">My Response</h4>
                <router-link to="/form" class="btn btn-primary btn-lg btn-block">+ Response to Form</router-link>
            </div>
        </div>
        <div class="section-body">
            <div class="row mb-4">

                <!-- S: Not has response yet -->
                <div class="col-md-12" v-if="responses.length == 0">
                    <div class="alert alert-warning">
                        You don't have any response to form yet
                    </div>
                </div>
                <!-- E: Not has response yet -->

                <!-- S: Form Response Section -->
                <div class="col-md-6" v-for="response in responses">
                    <div class="card card-default">
                        <div class="card-header border-0 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ response.form.name }}</h5>
                            <div>
                                <span class="badge bg-info" v-if="response.form.type == 'public'">Public</span>
                                <span class="badge bg-info" v-else>Private</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped mb-0">
                                <tbody>
                                    <tr v-for="(answer, key) in response.answers">
                                        <th>{{ key }}</th>
                                        <td class="text-muted">{{ answer}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- S: Form Response Section -->
            </div>

        </div>
    </section>
    <!-- E: My Response Section -->

</template>
<script>
    import axios from 'axios'

    export default {
        data() {
            return {
                responses: []
            }
        },
        mounted() {
            this.getAllMyResponse()
        },
        methods: {
            getToken() {
                return localStorage.getItem('token')
            },
            getAllMyResponse() {
                axios.get(import.meta.env.VITE_BASE_API_URL+'/response/mine?token='+this.getToken())
                    .then(res => {
                        this.responses = res.data.responses
                    }).catch(err => {
                        alert(err.response.data.message)
                    })
            }
        }
    }
</script>