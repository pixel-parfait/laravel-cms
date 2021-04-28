<template>
    <div>
        <div class="view-head">
            <h1 class="title">
                Pages
            </h1>
        </div>

        <!-- <div class="level">
            <div class="level-left">

            </div>

            <div class="level-right">
                <router-link :to="{ name: 'pages.create' }" class="button is-primary">
                    <span class="icon">
                        <fa-icon icon="plus"></fa-icon>
                    </span>
                    <span>New page</span>
                </router-link>
            </div>
        </div> -->

        <table class="table is-striped is-fullwidth">
            <thead>
                <tr>
                    <th>Title</th>
                    <th width="180">Index</th>
                    <th width="180">Created at</th>
                    <th width="130"></th>
                </tr>
            </thead>

            <tbody v-if="isLoading && ! results.data">
                <tr>
                    <td colspan="4" align="center">
                        <div class="loading-spinner"></div>
                    </td>
                </tr>
            </tbody>

            <tbody v-else-if="results.data.length">
                <tr v-for="page in results.data">
                    <td>
                        {{ page.title }}
                        <span class="tag is-warning" v-if="page.draft">Draft</span>
                    </td>
                    <td>
                        {{ page.index }}
                    </td>
                    <td>
                        {{ page.created_at | date }}
                    </td>
                    <td>
                        <div class="buttons is-right">
                            <a class="button is-small" :href="page.url" target="_blank" title="View page">
                                <span class="icon is-small">
                                    <fa-icon icon="eye"></fa-icon>
                                </span>
                            </a>

                            <router-link class="button is-small" :to="{ name: 'pages.edit', params: {id: page.id} }" title="Edit page">
                                <span class="icon is-small">
                                    <fa-icon icon="edit"></fa-icon>
                                </span>
                            </router-link>

                            <!-- <button class="button is-small" title="Delete page" @click="deletePage(page.id)">
                                <span class="icon is-small">
                                    <fa-icon icon="trash"></fa-icon>
                                </span>
                            </button> -->
                        </div>
                    </td>
                </tr>
            </tbody>

            <tbody v-else>
                <tr>
                    <td colspan="4">
                        You didn't create any page yet.
                    </td>
                </tr>
            </tbody>
        </table>

        <pagination :data="results" @pagination-change-page="loadPages"></pagination>
    </div>
</template>

<script>
export default {
    data () {
        return {
            results: {},
            isLoading: true
        }
    },
    created () {
        this.loadPages()
    },
    methods: {
        loadPages (page = 1) {
            this.axios
                .get(`/api/pages?page=${page}`)
                .then(response => {
                    this.results = response.data
                    this.isLoading = false
                })
        },
        deletePage (id) {
            this.$swal({
                title: "Confirm",
                text: 'Do you wish to remove this page?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.value) {
                    this.axios
                        .delete(`/api/pages/${id}`)
                        .then(response => {
                            let index = this.results.data.map(item => item.id).indexOf(id)

                            this.results.data.splice(index, 1)
                            this.total--

                            this.$swal({
                                text: response.data,
                                toast: true,
                                position: 'top-end',
                                timer: 3000,
                            })
                        })
                }
            })
        }
    }
}
</script>
