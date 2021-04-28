<template>
    <div>
        <div class="view-head">
            <h1 class="title">
                New page
            </h1>

            <div class="buttons are-small">
                <router-link :to="{ name: 'pages.index' }" class="button">
                    Back
                </router-link>
            </div>
        </div>

        <page-form :data="data" :locale="$store.state.defaultLocale" @submit="createPage"></page-form>
    </div>
</template>

<script>
import store from '../../store'
import PageForm from './PageForm'

export default {
    data () {
        return {
            isLoading: false,
            data: {
                page: {},
                errors: [],
            },
        }
    },
    components: {
        PageForm,
    },
    methods: {
        createPage (draft) {
            this.isLoading = true
            this.data.errors = []

            this.data.page.draft = draft

            this.axios
                .post('/api/pages', this.data.page)
                .then(response => {
                    this.$swal({
                        text: response.data.message,
                        toast: true,
                        position: 'top-end',
                        timer: 3000,
                    })

                    this.$router.push({
                        name: 'pages.edit',
                        params: {
                            id: response.data.page.id
                        }
                    })
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.data.errors = error.response.data.errors
                    }
                })
                .finally(() => this.isLoading = false)
        }
    }
}
</script>
