<template>
	<view>
		<view>
			<uni-list-item title="头像" link="reLaunch" style="justify-content: center;" @click="changeUserpic">
				<image slot="footer" :src="userpic" mode="aspectFill" style="height: 100rpx;width: 100rpx;" class="rounded-circle"></image>
			</uni-list-item>
			<uni-list-item title="昵称">
				<view slot="footer" class="flex justify-center">
					<!-- <input type="text" v-model="username" class="uni-input text-right"/> -->
					<input type="text" v-model="username" class="uni-input text-right" />
					<text class="iconfont icon-bianji1"></text>
				</view>
			</uni-list-item>
			<uni-list-item title="性别">
				<view slot="footer" class="align-center flex" @click="changeSex">
					<text>{{sexText}}</text>
					<text class="iconfont icon-bianji1"></text>
				</view>

			</uni-list-item>


			<uni-list-item title="生日">
				<view class="flex align-center" slot="footer">
					<picker mode="date" @change="onDateChange" :value="birthday">
						<text>{{birthday}}</text>
					</picker>
					<text class="iconfont icon-bianji1"></text>
				</view>
			</uni-list-item>


			<uni-list-item title="情感" link="reLaunch" @click="changeEmotion">
				<text slot="footer">{{emotionText}}</text>
			</uni-list-item>
			<uni-list-item title="职业">
				<view slot="footer" class="flex justify-center">
					<input type="text" v-model="job" class="uni-input text-right" />
					<text class="iconfont icon-bianji1"></text>
				</view>
			</uni-list-item>
			<uni-list-item title="家乡" @click="showTest" link="reLaunch">
				<text slot="footer">{{city}}</text>
			</uni-list-item>

			<template v-if="show">
				<picker-view indicator-style="height: 50px; " style="width: 100%; height: 100px;" :value="value" @change="bindChange">
					<picker-view-column>
						<view v-for="(item,Index) in provinces" :key="Index">{{item}}</view>
					</picker-view-column>
					<picker-view-column>
						<view v-for="(item,Index) in citys" :key="Index">{{item}}</view>
					</picker-view-column>
					<picker-view-column>
						<view v-for="(item,Index) in areas" :key="Index">{{item}}</view>
					</picker-view-column>
				</picker-view>
				
			</template>

		</view>
		<button class="bg-main text-white" style="border-radius: 50rpx;border: 0;" type="primary" @click="confirm">{{xiu}}</button>
	</view>
</template>

<script>
	const cityData = require('@/components/uni-ui/uni-city-picker/citydata.json');
	const sexArray = ['保密', '男', '女']
	const emotionArray = ['保密', '未婚', '已婚']
	const jobArray = ['保密', 'IT', '农民']
	import uniListItem from "@/components/uni-ui/uni-list-item/uni-list-item.vue"
	export default {
		components: {
			uniListItem,
		},
		data() {
			return {
				xiu:"完成",
				userpic: "/static/default.jpg",
				username: "小雨",
				sex: 1,
				emotion: 0,
				job: "前端工程师",
				birthday: "1999-07-03",
				city: "",
				show: false,
				citysData: cityData,
				provinces: [],
				citys: [],
				areas: [],
				value: [0, 0, 0],
				name: '',
				regionName: false
			}
		},
		onLoad(e) {
			this.initData();
			this.sex = e.sex;
		},
		computed: {
			sexText() {
				return sexArray[this.sex]
			},
			emotionText() {
				return emotionArray[this.emotion]
			},
		},
		methods: {
			showTest() {
				console.log(1111)
				this.show = true,
				this.xiu = "确认地址"
			},
			confirm(){
			this.show = false,	
			this.xiu = "完成"
			},
			//修改生日
			onDateChange(e) {
				this.birthday = e.detail.value
			},
			//修改头像
			changeUserpic() {
				uni.chooseImage({
					count: 1, //默认9
					sizeType: ['compressed'], //可以指定是原图还是压缩图，默认二者都有
					sourceType: ['album', 'camera'], //从相册选择
					success: (res) => {
						this.userpic = res.tempFilePaths[0]
					}
				});
			},
			changeSex() {
				uni.showActionSheet({
					itemList: sexArray,
					success: (res) => {
						this.sex = res.tapIndex
					}
				});
			},
			changeEmotion() {
				uni.showActionSheet({
					itemList: emotionArray,
					success: (res) => {
						this.emotion = res.tapIndex
					}
				});
			},


			initData() {
				var provinces = [];
				var citys = [];
				var areas = [];

				this.citysData.forEach(function(province, i) {
					provinces.push(province.name);
					if (i === 0) {
						citys.push(province.citys[i].name);
						areas = province.citys[i].areas;
					}
				});

				this.provinces = provinces;
				this.citys = citys;
				this.areas = areas;

			},

			bindChange(e) {
				var citysData = this.citysData;
				var value = this.value;
				var current_value = e.detail.value;
				var citys = [];
				var provinceObj = {};
				var cityObj = {};
				provinceObj = citysData[current_value[0]];

				if (value[0] !== current_value[0]) {
					// 滑动省份
					provinceObj.citys.forEach(function(v) {
						citys.push(v.name);
					});

					this.citys = citys;
					cityObj = provinceObj.citys[0];

					this.areas = cityObj.areas;
					this.value = [current_value[0], 0, 0];
				} else if (value[0] === current_value[0] && value[1] !== current_value[1]) {
					// 滑动城市
					if (current_value[1] >= provinceObj.citys.length) {
						// 数据不存在 跳过
						return;
					}
					cityObj = provinceObj.citys[current_value[1]];
					this.areas = cityObj.areas;
					this.value = [current_value[0], current_value[1], 0];

				} else {
					// 滑动区县
					cityObj = provinceObj.citys[current_value[1]];
					this.value = current_value;

				}
				this.name = provinceObj.name + '-' + cityObj.name + '-' + cityObj.areas[this.value[2]];
				this.regionName = true
				this.city = this.name
			}




		}
	}
</script>

<style>

</style>
