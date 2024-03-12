<script setup>
    import FormDetailCreator from './FormDetailCreator.vue';
    import FormDetailNotCreator from './FormDetailNotCreator.vue';
</script>

<template>
    <FormDetailCreator v-if="form.is_creator" :form="form"/>
    <FormDetailNotCreator v-else :form="form"/>
</template>

<script>
    import axios from 'axios'

    export default {
        props: ['form_id'],
        data() {
            return {
                form: {
                    name: "",
                    description: "",
                    type: "",
                    expired: "",
                    is_creator: false,
                    respondens: [],
                    questions: [],
                    domains: []
                }
            }
        },
        mounted() {
            this.getFormDetail()
        },
        methods: {
            getFormDetail() {
                axios.get(import.meta.env.VITE_BASE_API_URL+'/forms/'+this.form_id+'?token='+this.$getToken())
                .then(res => {
                        this.form = res.data.form
                        this.$emit('changePageTitle', this.form.name)
                    }).catch(err => {
                        alert(err.response.data.message)
                    })
            }
        }
    }
</script>