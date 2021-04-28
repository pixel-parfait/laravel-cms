<template>
    <div>
        <div class="view-head">
            <div>
                <h1 class="title">
                    {{ page_title }} <span class="tag is-warning" v-if="data.page.draft">Draft</span>
                </h1>

                <a class="subtitle is-7" :href="data.page.url" target="_blank">
                    {{ data.page.url }}
                </a>
            </div>

            <div class="buttons are-small">
                <router-link :to="{ name: 'pages.index' }" class="button">
                    Back
                </router-link>
            </div>
        </div>

        <page-form v-if="data.page.id" :data="data" :locale="$store.state.defaultLocale" :isLoading="isLoading" @submit="updatePage"></page-form>
    </div>
</template>

<script>
import store from '../../store'
import PageForm from './PageForm'

export default {
    data () {
        return {
            page_title: '',
            isLoading: false,
            data: {
                page: {},
                errors: [],
            },
        }
    },
    created () {
        this.axios
            .get(`/api/pages/${this.$route.params.id}`)
            .then((response) => {
                this.page_title = response.data.title
                this.data.page = response.data
            })
    },
    components: {
        PageForm,
    },
    methods: {
        updatePage (draft) {
            this.isLoading = true
            this.data.errors = []

            this.data.page.draft = draft

            this.axios
                .post('/api/pages/' + this.$route.params.id, {
                    _method: 'put',
                    ...this.data.page
                })
                .then(response => {
                    this.$swal({
                        text: response.data,
                        toast: true,
                        position: 'top-end',
                        timer: 3000,
                    })

                    this.page_title = this.data.page.title
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
