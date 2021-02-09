<template>
	<view>
		<!-- 聊天列表 -->
		<scroll-view scroll-y="true" style="position: absolute;left: 0;right: 0;top: 0;bottom: 100rpx;" :scroll-into-view="scrollInto" scroll-with-animation>
			<!-- 气泡 -->
			<block v-for="(item,index) in list" :key="index">
				<view :id="'chat'+index">
					<user-chat-list :item="item" :index="index" :preTime="index > 0 ? list[index-1].create_time : 0"></user-chat-list>
				</view>
			</block>
		</scroll-view>
		
		<bottom-input @submit="submit"></bottom-input>
		<!-- 底部操作条 -->
		<!-- <view style="height: 100rpx;" class="fixed-bottom flex align-center justify-center border-top bg-white px-2">
			<input type="text" placeholder="文明发言" v-model="content" class="flex-1 rounded bg-light mr-2" style="padding: 5rpx;" :adjust-position="true" @confirm="submit"/>
			<view class="iconfont icon-fabu flex align-center justify-center font-lg animated" style="width: 100rpx;" hover-class="jello text-main" @click="submit"></view>
		</view> -->
	</view>
</template>

<script>
	import userChatList from "@/components/user-chat/user-chat-list.vue"
	import bottomInput from "@/components/common/bottom-input.vue"
	export default {
		components:{
			userChatList,
			bottomInput
		},
		data() {
			return {
				scrollInto:"",
				list:[{
					user_id:1,
					avatar:"/static/default.jpg",
					username:"杨雨",
					data:"你好啊",
					type:"text",
					create_time:1611721346
				},
				{
					user_id:1,
					avatar:"/static/default.jpg",
					username:"杨雨",
					data:"你好啊",
					type:"text",
					create_time:1611721346
				},
				{
					user_id:2,
					avatar:"/static/default.jpg",
					username:"杨雨",
					data:"你好啊",
					type:"text",
					create_time:1611721346
				},
				{
					user_id:1,
					avatar:"/static/default.jpg",
					username:"杨雨",
					data:"你好啊",
					type:"text",
					create_time:1611721346
				},
				{
					user_id:1,
					avatar:"/static/default.jpg",
					username:"杨雨",
					data:"你好啊",
					type:"text",
					create_time:1611721346
				},
				{
					user_id:2,
					avatar:"/static/default.jpg",
					username:"杨雨",
					data:"你好啊",
					type:"text",
					create_time:1611721346
				},
				{
					user_id:1,
					avatar:"/static/default.jpg",
					username:"杨雨",
					data:"你好啊",
					type:"text",
					create_time:1611721346
				},
				{
					user_id:1,
					avatar:"/static/default.jpg",
					username:"杨雨",
					data:"你好啊",
					type:"text",
					create_time:1611721346
				},
				{
					user_id:1,
					avatar:"/static/default.jpg",
					username:"杨雨",
					data:"你好啊",
					type:"text",
					create_time:1611721346
				},
				{
					user_id:1,
					avatar:"/static/default.jpg",
					username:"杨雨",
					data:"你好啊",
					type:"text",
					create_time:1611721346
				},
				{
					user_id:2,
					avatar:"/static/default.jpg",
					username:"杨雨",
					data:"你好啊",
					type:"text",
					create_time:1611721346
				},
				{
					user_id:2,
					avatar:"/static/default.jpg",
					username:"杨雨",
					data:"你好啊",
					type:"text",
					create_time:1611721346
				},
				{
					user_id:1,
					avatar:"/static/default.jpg",
					username:"杨雨",
					data:"你好啊",
					type:"text",
					create_time:1611721346
				},
				],
				content:""
			}
		},
		onReady(){
			  this.pageToBottom();
		},
		methods: {
			submit(e){
				let obj = {
					user_id:1,
					avatar:"/static/default.jpg",
					username:"杨雨",
					type:"text",
					data:e,
					create_time:(new Date()).getTime()
				}
				if(e === ""){
					uni.showToast({
						title:"消息不能为空",
					})
					
				}else{
					this.list.push(obj)
					this.content = "";
					setTimeout(()=>{
						this.pageToBottom();
					},100)
				}
			},
			//滚动到底部的方法
			pageToBottom(){
				let lastIndex = this.list.length - 1
				if(lastIndex < 0) return;
					this.scrollInto = 'chat'+lastIndex
			},
		}
	}
</script>

<style>

</style>
