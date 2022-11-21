import Vote from '../components/Vote.vue';
import UserInfo from '../components/UserInfo.vue';
import MEditor from '../components/MEditor.vue';
import highlight from './highlight';
import destroy from './destroy';
import EventBus from '../event-bus'

export default {
    mixins: [highlight, destroy],

    components: {Vote, UserInfo, MEditor  },

    data () {
        return {
            editing: false
        }
    },

    methods: {
        edit () {
            this.setEditCache();
            this.editing = true;
        },

        cancel () {
            this.restoreFromCache();
            this.editing = false;
        },

        setEditCache () {},
        restoreFromCache () {},

        update() {
            axios.put(this.endpoint, this.payload())
            .catch(({ response }) => {
                this.$toast.error(response.data.message, "Failed", { timeout: 3000 });
                EventBus.$emit('error', response.data.data);
            })
            .then(({ data }) => {
                if (data.question) {
                    this.bodyHtml = data.question.body_html;
                } else if (data.answer) {
                    this.bodyHtml = data.answer.body_html;
                }
                // setTimeout(function () { document.location.reload(true); }, 3000);
                this.$toast.success(data.message, "Success", { timeout: 3000 });
                this.editing = false;
            })
            .then(() => this.highlight());
        },

        payload () {},
    }
}
