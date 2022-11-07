export default {
    methods: {
        destroy() {
            this.$toast.question('Are you sure about that?', "Confirm", {
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Hey',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', (instance, toast) => {
                    
                        this.delete();

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }, true],
                    ['<button>NO</button>', function (instance, toast) {

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }],
                ]
            });
        },

        delete() {
            axios.delete("/questions/" + this.question.id)
                .then(({data}) => {
                    this.$toast.success(data.message, "Success", { timeout: 2000 });
                    this.$emit('deleted');
                });
        }
    }
}