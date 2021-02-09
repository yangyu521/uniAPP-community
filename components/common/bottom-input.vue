<template>
	<!-- 底部操作条 -->
	<view style="height: 100rpx;" class="fixed-bottom flex align-center justify-center border-top bg-white px-2">
		<input type="text" placeholder="文明发言" v-model="content" class="flex-1 rounded bg-light mr-2" style="padding: 5rpx;" :adjust-position="true" @confirm="submit"/>
		<view class="iconfont icon-fabu flex align-center justify-center font-lg animated" style="width: 100rpx;" hover-class="jello text-main" @click="submit"></view>
	</view>
</template>

<script>
	export default {
		data(){
			return{
				content:""
			}
		},
		methods:{
		submit(){
			if(this.content === ""){
				uni.showToast({
					title:"消息不能为空"
				})
			}
			this.$emit('submit',this.content)
			this.content = ""
		}
	},
	}
 </script>

<style>
</style>
