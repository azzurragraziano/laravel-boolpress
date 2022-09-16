<template>
    <div class="container">
        <h1>contact us</h1>

        <div v-if="success" class="alert alert-success" role="alert">
            thanks for contacting us
        </div>

        <form @submit.prevent="sendMessage()">
            <!-- name -->
            <div class="mb-3">
                <label for="user-name" class="form-label">name</label>
                <input v-model="userName" type="text" class="form-control" id="user-name">

                <div class="mt-2" v-if="errors.name">
                    <div v-for="error, index in errors.name" :key="index" class="alert alert-danger" role="alert">
                        {{error}}
                    </div>
                </div>
            </div>

            <!-- email -->
            <div class="mb-3">
                <label for="user-email" class="form-label">email</label>
                <input v-model="userEmail" type="email" class="form-control" id="user-email">

                <div class="mt-2" v-if="errors.email">
                    <div v-for="error, index in errors.email" :key="index" class="alert alert-danger" role="alert">
                        {{error}}
                    </div>
                </div>
            </div>

            <!-- message -->
            <div class="mb-3">
                <label for="user-message" class="form-label">message</label>
                <textarea v-model="userMessage" class="form-control" id="user-message" rows="5"></textarea>
            
                <div class="mt-2" v-if="errors.message">
                    <div v-for="error, index in errors.message" :key="index" class="alert alert-danger" role="alert">
                        {{error}}
                    </div>
                </div>
            </div>

            <input type="submit" class="btn btn-primary" value="send" :disable="sending">
        </form>
    </div>
</template>

<script>
export default {
    name: 'Contact',  
    data() {
        return {
            userName: '',
            userEmail: '',
            userMessage: '',
            success: false,
            errors: {},
            sending: false
        }
    },
    methods: {
        sendMessage() {
            this.sending = true;

            axios.post('/api/leads', {
                name: this.userName,
                email: this.userEmail,
                message: this.userMessage
            })
            .then((response) => {
                if (response.data.success) {
                    this.success = true;

                    this.userName = '';
                    this.userEmail = '';
                    this.userMessage = '';
                    this.errors = {};
                } else {
                    this.errors = response.data.errors;
                }
            });

            this.sending = false;
        }
    }
}
</script>
