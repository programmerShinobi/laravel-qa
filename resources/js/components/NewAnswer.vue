<template>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>Your Answer</h3>
                    </div>
                    <hr>
                    <form @submit.prevent="create">
                        <div class="form-group">
                            <m-editor :body="body" name="new-answer">
                                <textarea v-model="body" class="form-control" name="body" id="" rows="7" required></textarea>
                            </m-editor>
                        </div>
                        <div class="form-group">
                            <button :disabled="isInvalid" class="btn btn-lg btn-outline-primary" type="submit">
                                <!-- <spinner :small="true" :min-width="59.23" v-if="$root.loading"></spinner> -->
                                <preloader :small="true" v-if="$root.loading"></preloader>
                                <span v-else>Submit</span>
                            </button>                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MEditor from './MEditor.vue';
import Preloader from './Preloader.vue'
export default {
    props: ['questionId'],

    components: {
        MEditor,
        Preloader,
    },

    methods: {
        create() {
            if (! this.signedIn) {
                this.$toast.warning(`Please login to answer the question`, "Warning", {
                    timout: 3000,
                    position: 'bottomLeft'
                });
                return;
            }

            if (! window.Auth.user.email_verified_at) {
                this.$toast.warning(`Please check your email for a verification link`, "Warning", {
                    timout: 3000,
                    position: 'bottomLeft'
                });
                return;
            }
    
            axios.post(`/questions/${this.questionId}/answers`, {
                body: this.body
            })
            .catch(error => {
                this.$toast.error(error.response.data.message, "Error");
            })
            .then(({ data }) => {
                this.$toast.success(data.message, "Success");    
                this.body = '';
                this.$emit('created', data.answer);
            })
          
        },
    },
    data() {
        return {
            body: '',
        }
    },

    computed: {
        isInvalid() {
            return this.body.length < 10;
        },
    },
}
</script>