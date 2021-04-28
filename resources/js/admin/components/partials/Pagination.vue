<template>
    <renderless-pagination
        :data="data"
        :limit="limit"
        v-on:pagination-change-page="onPaginationChangePage">

        <nav class="pagination"
            v-if="computed.total > computed.perPage"
            slot-scope="{ data, limit, showDisabled, size, align, computed, prevButtonEvents, nextButtonEvents, pageButtonEvents }">

            <a class="pagination-previous" href="#" aria-label="Previous" :tabindex="! computed.prevPageUrl && -1" v-on="prevButtonEvents" :disabled="! computed.prevPageUrl">
                Previous
            </a>

            <a class="pagination-next" href="#" aria-label="Next" :tabindex="! computed.nextPageUrl && -1" v-on="nextButtonEvents" :disabled="! computed.nextPageUrl">
                Next
            </a>

            <ul class="pagination-list">
                <li v-for="(page, key) in computed.pageRange" :key="key">
                    <a class="pagination-link" :class="{'is-current': page == computed.currentPage}" href="#" v-on="pageButtonEvents(page)">
                        {{ page }}
                    </a>
                </li>
            </ul>
        </nav>
    </renderless-pagination>
</template>

<script>
import RenderlessPagination from './RenderlessPagination.vue';

export default {
    props: {
        data: {
            type: Object,
            default: () => {}
        },
        limit: {
            type: Number,
            default: 4
        }
    },
    methods: {
        onPaginationChangePage (page) {
            this.$emit('pagination-change-page', page);
        }
    },
    components: {
        RenderlessPagination
    }
}
</script>
