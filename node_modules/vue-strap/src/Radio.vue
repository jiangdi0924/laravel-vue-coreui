<template>
  <div :is="buttonStyle?'label':'div'" @click.prevent="toggle"
    :class="[(buttonStyle?'btn btn-'+typeColor:'radio '+typeColor),{active:active,disabled:disabled,readonly:readonly}]"
  >
    <template v-if="buttonStyle">
      <input type="radio" autocomplete="off" ref="input"
        v-show="!readonly"
        v-model="check"
        :value="selectedValue"
        :name="name"
        :readonly="readonly"
        :disabled="disabled"
      />
      <slot></slot>
    </template>
    <label v-else class="open">
      <input type="radio" autocomplete="off" ref="input"
        v-model="check"
        :value="selectedValue"
        :name="name"
        :readonly="readonly"
        :disabled="disabled"
      />
      <span class="icon dropdown-toggle" :class="[active?'btn-'+typeColor:'',{bg:typeColor==='default'}]"></span>
      <span v-if="active&&typeColor==='default'" class="icon"></span>
      <slot></slot>
    </label>
  </div>
</template>

<script>
export default {
  props: {
    button: {type: Boolean, default: false},
    disabled: {type: Boolean, default: false},
    name: {type: String, default: null},
    readonly: {type: Boolean, default: false},
    selectedValue: {default: true},
    type: {type: String, default: null},
    value: {default: false}
  },
  data () {
    return {
      check: this.value
    }
  },
  computed: {
    active () { return this.check === this.selectedValue },
    inGroup () { return this.$parent && this.$parent.btnGroup && !this.$parent._checkboxGroup },
    parentValue () { return this.$parent.val },
    buttonStyle () { return this.button || (this.$parent && this.$parent.btnGroup && this.$parent.buttons) },
    typeColor () { return (this.type || (this.$parent && this.$parent.type)) || 'default' }
  },
  watch: {
    check (val) {
      if (this.selectedValue === val) {
        this.$emit('input', val)
        this.$emit('checked', true)
        this.updateParent()
      }
    },
    parentValue (val) {
      this.updateFromParent()
    },
    value (val) {
      if (this.selectedValue == val) {
        this.check = val
      } else {
        this.check = false
      }
    }
  },
  created () {
    if (this.inGroup) {
      var parent = this.$parent
      parent._radioGroup = true
      this.updateFromParent()
    }
  },
  methods: {
    updateFromParent() {
      if (this.inGroup) {
        if (this.selectedValue == this.$parent.val) {
          this.check = this.selectedValue
        } else {
          this.check = false
        }
      }
    },
    updateParent() {
      if (this.inGroup) {
        if (this.selectedValue === this.check) {
          this.$parent.val = this.selectedValue
        }
      }
    },
    focus () {
      this.$refs.input.focus()
    },
    toggle () {
      if (this.disabled) { return }
      this.focus()
      if (this.readonly) { return }
      this.check = this.selectedValue
    }
  }
}
</script>

<style scope>
.radio { position: relative; }
.radio > label > input {
  position: absolute;
  margin: 0;
  padding: 0;
  opacity: 0;
  z-index: -1;
  box-sizing: border-box;
}
.radio > label > .icon {
  position: absolute;
  top: .15rem;
  left: 0;
  display: block;
  width: 1.4rem;
  height: 1.4rem;
  text-align: center;
  user-select: none;
  border-radius: .7rem;
  background-repeat: no-repeat;
  background-position: center center;
  background-size: 50% 50%;
}
.radio:not(.active) > label > .icon {
  background-color: #ddd;
  border: 1px solid #bbb;
}
.radio > label > input:focus ~ .icon {
  outline: 0;
  border: 1px solid #66afe9;
  box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);
}
.radio.active > label > .icon {
  background-size: 1rem 1rem;
  background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjxzdmcgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxjaXJjbGUgY3g9IjUiIGN5PSI1IiByPSI0IiBmaWxsPSIjZmZmIi8+PC9zdmc+);
}
.radio.active .btn-default { filter: brightness(75%); }

.radio.disabled > label > .icon,
.radio.readonly > label > .icon,
.btn.readonly {
  filter: alpha(opacity=65);
  box-shadow: none;
  opacity: .65;
}
label.btn > input[type=radio] {
  position: absolute;
  clip: rect(0,0,0,0);
  pointer-events: none;
}
</style>
