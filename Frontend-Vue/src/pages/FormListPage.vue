<template>
    <div class="container mb-5">
        <div class="section-header mb-4">
            <h4 class="section-title text-muted font-weight-normal">
                List of form that you can response
            </h4>
        </div>

        <div class="section-body">
            <article class="spot" v-for="form in forms">
                <div class="row">
                    <div class="col-9">
                        <h5 class="text-primary">
                            {{ form.name }}
                            <span class="badge bg-success" v-if="form.type == 'public'">Public</span>
                            <span class="badge bg-info" v-else>Private</span>
                        </h5>
                        <div class="text-muted">{{ form.respondens_count }} respondens</div>
                        <div class="text-muted">
                            {{ form.description }}
                        </div>
                    </div>
                    <div class="col-3">
                        <router-link class="btn btn-success btn-lg btn-block" :to="'form/'+form.id">
                            Response / Detail
                        </router-link>
                    </div>
                </div>
            </article>
            <!-- <article class="spot">
            <div class="row">
                <div class="col-9">
                <h5 class="text-primary">
                    Form Name <span class="badge bg-info">Private</span>
                </h5>
                <div class="text-muted">0 respondens</div>
                <div class="text-muted">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Magnam, delectus.
                </div>
                </div>
                <div class="col-3">
                <button class="btn btn-success btn-lg btn-block">
                    Response / Detail
                </button>
                </div>
            </div>
            </article>
            <article class="spot unavailable">
            <div class="row">
                <div class="col-9">
                <h5 class="text-primary">
                    Form Name <span class="badge bg-success">Public</span>
                </h5>
                <div class="text-muted">0 respondens</div>
                <div class="text-muted">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Magnam, delectus.
                </div>
                </div>
                <div class="col-3">
                <button class="btn btn-danger btn-lg btn-block">
                    Form already expired
                </button>
                </div>
            </div>
            </article> -->
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        data() {
            return {
                forms: []
            }
        },
        mounted() {
            this.getAllForms()
        }, 
        beforeCreate() {
            this.$emit('changePageTitle', 'Form List')
        },
        methods: {
            getAllForms() {
                axios.get(import.meta.env.VITE_BASE_API_URL+'/forms?token='+this.$getToken())
                    .then(res => {
                        this.forms = res.data.forms
                    })
                    .catch(err => {alert(err.response.data.message)})
            }
        }
    }
</script>