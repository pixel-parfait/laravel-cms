<template>
    <div>
        <div class="view-head">
            <h1 class="title">
                {{ page_title }} <span class="tag is-warning" v-if="data.page.draft">Draft</span>
            </h1>

            <div class="buttons are-small">
                <router-link :to="{ name: 'pages.index' }" class="button">
                    Back
                </router-link>
            </div>
        </div>

        <page-form v-if="data.page.id" :data="data" :locale="locale" :isLoading="isLoading" @submit="updatePost"></page-form>
    </div>
</template>

<script>
import store from '../../store'
import PostForm from './PageForm'

export default {
    data () {
        return {
            page_title: '',
            locale: this.$route.params.locale,
            isLoading: false,
            data: {
                page: {},
                errors: [],
            },
        }
    },
    created () {
        if (this.$store.state.availableLocales.indexOf(this.$route.params.locale) < 0) {
            this.$router.replace({
                name: 'pages.edit',
                params: {
                    id: this.$route.params.id
                }
            })
        }

        this.axios
            .get(`/api/pages/${this.$route.params.id}/translate/${this.$route.params.locale}`)
            .then((response) => {
                this.page_title = response.data.original_title
                this.data.page = response.data || {}
            })
    },
    components: {
        PostForm,
    },
    methods: {
        updatePost (draft) {
            this.isLoading = true
            this.data.errors = []

            this.data.page.draft = draft

            this.axios
                .post(`/api/pages/${this.$route.params.id}/translate/${this.$route.params.locale}`, {
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
