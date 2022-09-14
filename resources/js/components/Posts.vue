<template>
    <section>
        <div class="container">
            <h2>
                blog
            </h2>

            <div class="row row-cols-3">
                <div v-for="post in posts" :key="post.id" class="col">
                    <div class="card mt-3">
                        <!-- <img src="..." class="card-img-top" alt="..."> -->
                        <div class="card-body">
                            <h5 class="card-title">{{post.title}}</h5>
                            <p class="card-text">{{truncateText(post.content)}}</p>
                            <a href="#" class="btn btn-primary">Find out more</a>
                        </div>
                    </div>
                </div>
            </div>

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

export default {
    name: 'Posts', 
    data() {
        return {
            posts:[],
            paginationCurrentPage: 1,
            paginationLastPage: null
        };
    },
    methods: {
        truncateText(text) {
            if(text.length > 100) {
                return text.slice(0, 100) + '...'
            }

            return text;
        },
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
