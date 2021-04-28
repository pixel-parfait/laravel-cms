<template>
    <div>
        <div class="view-head">
            <h1 class="title">
                {{ post_title }} <span class="tag is-warning" v-if="data.post.draft">Draft</span>
            </h1>

            <div class="buttons are-small">
                <router-link :to="{ name: 'posts.index' }" class="button">
                    Back
                </router-link>
            </div>
        </div>

        <post-form v-if="data.post.id" :data="data" :locale="$store.state.defaultLocale" :isLoading="isLoading" @submit="updatePost"></post-form>
    </div>
</template>

<script>
import store from '../../store'
import PostForm from './PostForm'

export default {
    data () {
        return {
            post_title: '',
            isLoading: false,
            data: {
                post: {},
                errors: [],
            },
        }
    },
    created () {
        this.axios
            .get(`/api/posts/${this.$route.params.id}`)
            .then((response) => {
                this.post_title = response.data.title
                this.data.post = response.data
            })
    },
    components: {
        PostForm,
    },
    methods: {
        updatePost (draft) {
            this.isLoading = true
            this.data.errors = []

            this.data.post.draft = draft

            this.axios
                .post('/api/posts/' + this.$route.params.id, {
                    _method: 'put',
                    ...this.data.post
                })
                .then(response => {
                    this.$swal({
                        text: response.data,
                        toast: true,
                        position: 'top-end',
                        timer: 3000,
                    })

                    this.post_title = this.data.post.title
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
