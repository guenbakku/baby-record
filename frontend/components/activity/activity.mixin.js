export default {
  props: {
    color: String
  },
  computed: {
    editRoute: function() {
      return {
        name: 'activities-type-id',
        params: {
          type: this.activity.activity_type.code,
          id: this.activity.id
        }
      }
    },
    typeStyle: function() {
      return {
        backgroundColor: this.color
      }
    }
  }
}
