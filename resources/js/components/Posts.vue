<template>
    <section>
        <div class="container">
            <h2>
                blog
            </h2>

            <div class="row row-cols-3">
                <div v-for="singlePost in posts" :key="singlePost.id" class="col">
                    <PostDetails :post="singlePost"/>
                </div>
            </div>

            <!-- pagination -->
            <nav class="mt-3">
                <ul class="pagination">
                    <!-- previous btn -->
                    <li class="page-item" :class="{'disabled': paginationCurrentPage == 1}">
                        <a @click.prevent="getPosts(paginationCurrentPage - 1)" class="page-link" href="#">
                            Previous
                        </a>
                    </li>
                    
                    <!-- pagination numbers -->
                    <li v-for="pageNumber in paginationLastPage" :key="pageNumber" class="page-item" :class="{'active': pageNumber == paginationCurrentPage}">
                        <a @click.prevent="getPosts(pageNumber)" class="page-link" href="#">{{pageNumber}}</a>
                    </li>

                    <!-- next btn -->
                    <li class="page-item" :class="{'disabled': paginationCurrentPage == paginationLastPage}">
                        <a @click.prevent="getPosts(paginationCurrentPage + 1)" class="page-link" href="#">
                            Next
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </section>
</template>

<script>
import PostDetails from './PostDetails.vue'

export default {
    name: 'Posts', 
    components: {
        PostDetails
    },
    data() {
        return {
            posts:[],
            paginationCurrentPage: 1,
            paginationLastPage: null
        };
    },
    methods: {
        getPosts(pageNumber) {
            axios.get('/api/posts', {
                params: {
                    page: pageNumber
                }
            })
            .then((response)=> {
                this.posts = response.data.results.data;
                this.paginationCurrentPage = response.data.results.current_page;
                this.paginationLastPage = response.data.results.last_page;
            });
        }
    },
    mounted() {
        this.getPosts();
    }
}
</script>
